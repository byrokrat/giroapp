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
use byrokrat\id\PersonalId;
use byrokrat\amount\Currency\SEK;

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

        $this->setProperty('payerNumber', 'Unique ID number for donor', $input, $output, $donorBuilder);
        $this->setProperty('account', 'Donor account number', $input, $output, $donorBuilder);
        $this->setProperty('id', 'Donor personal id number or organisation number', $input, $output, $donorBuilder);
        $this->setProperty('name', 'Donor name', $input, $output, $donorBuilder);
        /**
        $this->setProperty('address1', 'Address field 1', $input, $output, $donorBuilder);
        $this->setProperty('address2', 'Address field 2', $input, $output, $donorBuilder);
        $this->setProperty('postalCode', 'Postal code', $input, $output, $donorBuilder);
        $this->setProperty('postalCity', 'Postal city', $input, $output, $donorBuilder);
        $this->setProperty('coAddress', 'C/o address', $input, $output, $donorBuilder);
         */
        $this->setProperty('email', 'Contact email address', $input, $output, $donorBuilder);
        $this->setProperty('phone', 'Contact phone number', $input, $output, $donorBuilder);
        $this->setProperty('donationAmount', 'Monthly donation amount', $input, $output, $donorBuilder);
        $this->setProperty('comment', 'Comment', $input, $output, $donorBuilder);

        $this->setAddress('address', 'Donor Address', $input, $output, $donorBuilder);
        $output->writeln($donorBuilder->buildDonor()->getComment());
    }

    private function setProperty(
        string $key,
        string $desc,
        InputInterface $input,
        OutputInterface $output,
        DonorBuilder $donorBuilder
    ) {
        $value = $input->getOption(str_replace('_', '-', $key));

        if (!$value) {
            $value = $this->command->getHelper('question')->ask(
                    $input,
                    $output,
                    new Question("$desc: ", '')
                );
        }
        switch ($key) {
            case 'id':
                $value = new PersonalId($value);
                break;
            case 'account':
                $accountFactory = new AccountFactory();
                $value = $accountFactory->createAccount($value);
                break;
            case 'donationAmount':
                $value = new SEK($value);
                break;
        }
        call_user_func([$donorBuilder,'set'.$key], $value);
    }

    private function setAddress(
        string $key,
        string $desc,
        InputInterface $input,
        OutputInterface $output,
        DonorBuilder $donorBuilder
    ) {
        $output->writeln('address fetcher not implement yet, so bang rocks together instead');
    }
}
