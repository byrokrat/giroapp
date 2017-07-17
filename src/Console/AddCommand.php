<?php
/**
 * This file is part of byrokrat\giroapp.
 *
 * byrokrat\giroapp is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * byrokrat\giroapp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with byrokrat\giroapp. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Builder\DonorBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Question\Question;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use byrokrat\amount\Currency\SEK;
use byrokrat\giroapp\Model\PostalAddress;

/**
 * Command to add a new mandate
 */
class AddCommand implements CommandInterface
{
    /**
     * @var Command
     */
    private $command;

    public function configure(Command $command)
    {
        $this->command = $command;
        $command->setName('add');
        $command->setDescription('Add a new donor');
        $command->setHelp('Register a new traditional printed mandate in database');
        $command->addOption('payerNumber', null, InputOption::VALUE_REQUIRED, 'Unique identifier number for the donor');
        $command->addOption('account', null, InputOption::VALUE_REQUIRED, 'Payer account number');
        $command->addOption('id', null, InputOption::VALUE_REQUIRED, 'Payer personal number or organisation number');
        $command->addOption('name', null, InputOption::VALUE_REQUIRED, 'Payer name');
        $command->addOption('address1', null, InputOption::VALUE_OPTIONAL, 'Address field 1');
        $command->addOption('address2', null, InputOption::VALUE_OPTIONAL, 'Address field 2');
        $command->addOption('postalCode', null, InputOption::VALUE_OPTIONAL, 'Postal code');
        $command->addOption('postalCity', null, InputOption::VALUE_OPTIONAL, 'Postal city');
        $command->addOption('coAddress', null, InputOption::VALUE_OPTIONAL, 'C/o address');
        $command->addOption('email', null, InputOption::VALUE_OPTIONAL, 'Contact email address');
        $command->addOption('phone', null, InputOption::VALUE_OPTIONAL, 'Contact phone number');
        $command->addOption('donationAmount', null, InputOption::VALUE_OPTIONAL, 'Monthly donation amount');
        $command->addOption('comment', null, InputOption::VALUE_OPTIONAL, 'Comment');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $donorBuilder = $container->get('donor_builder');
        $donorMapper = $container->get('donor_mapper');
        $accountFactory = $container->get('account_factory');
        $idFactory = $container->get('id_factory');

        $this->setPayerNumber(
            $this->getProperty('payerNumber', 'Unique ID number for donor', '', $input, $output),
            $donorBuilder
        );
        $this->setAccount(
            $this->getProperty('account', 'Donor account number', '', $input, $output),
            $donorBuilder,
            $accountFactory
        );
        $this->setId(
            $this->getProperty('id', 'Donor personal id number or organisation number', '', $input, $output),
            $donorBuilder,
            $idFactory
        );
        $this->setName(
            $this->getProperty('name', 'Donor name', '', $input, $output),
            $donorBuilder
        );
        $this->setPostalAddress(
            [
                'address1' => $this->getProperty('address1', 'Donor Address line 1', '', $input, $output),
                'address2' => $this->getProperty('address2', 'Donor Address line 2', '', $input, $output),
                'postalCode' => $this->getProperty('postalCode', 'Donor Postal code', '', $input, $output),
                'postalCity' => $this-> getProperty('postalCity', 'Donor Address city', '', $input, $output),
                'coAddress' => $this->getProperty('coAddress', 'C/o Address', '', $input, $output),
            ],
            $donorBuilder
        );
        $this->setEmail(
            $this->getProperty('email', 'Contact email address', '', $input, $output),
            $donorBuilder
        );
        $this->setPhone(
            $this->getProperty('phone', 'Contact phone number', '', $input, $output),
            $donorBuilder
        );
        $this->setDonationAmount(
            $this->getProperty('donationAmount', 'Monthly donation amount', '0', $input, $output),
            $donorBuilder
        );
        $this->setComment(
            $this->getProperty('comment', 'Comment', '', $input, $output),
            $donorBuilder
        );

        $donorMapper->save($donorBuilder->buildDonor());
        $output->writeln('donor saved');
    }

    private function getProperty(
        string $key,
        string $desc,
        string $default,
        InputInterface $input,
        OutputInterface $output
    ) {
        $value = $input->getOption(str_replace('_', '-', $key));

        if (!$value) {
            $value = $this->command->getHelper('question')->ask(
                $input,
                $output,
                new Question("$desc: ", $default)
            );
        }
        //$value = $value ?: "";
        return $value;
    }

    private function setPayerNumber(
        string $value,
        DonorBuilder $donorBuilder
    ) {
        $donorBuilder->setPayerNumber($value);
    }

    private function setAccount(
        $value,
        DonorBuilder $donorBuilder,
        AccountFactory $accountFactory
    ) {
        $newAccount = $accountFactory->createAccount($value);
        $donorBuilder->setAccount($newAccount);
    }

    private function setId(
        string $value,
        DonorBuilder $donorBuilder,
        IdFactory $idFactory
    ) {
        $newId = $idFactory->create($value);
        $donorBuilder->setId($newId);
    }

    private function setName(
        string $value,
        DonorBuilder $donorBuilder
    ) {
        $donorBuilder->setName($value);
    }

    private function setPostalAddress(
        array $values,
        DonorBuilder $donorBuilder
    ) {
        $newPostalAddress = new PostalAddress(
            $values['postalCode'],
            $values['postalCity'],
            $values['address1'],
            $values['address2'],
            $values['coAddress']
        );

        $donorBuilder->setPostalAddress($newPostalAddress);
    }

    private function setEmail(
        string $value,
        DonorBuilder $donorBuilder
    ) {
        $donorBuilder->setEmail($value);
    }

    private function setPhone(
        string $value,
        DonorBuilder $donorBuilder
    ) {
        $donorBuilder->setPhone($value);
    }

    private function setDonationAmount(
        string $value,
        DonorBuilder $donorBuilder
    ) {
        $newDonationAmount = new SEK($value);
        $donorBuilder->setDonationAmount($newDonationAmount);
    }

    private function setComment(
        string $value,
        DonorBuilder $donorBuilder
    ) {
        $donorBuilder->setComment($value);
    }
}
