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
use byrokrat\giroapp\Events;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use byrokrat\amount\Currency\SEK;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Event\DonorEvent;

/**
 * Command to edit an existing mandate
 */
class EditCommand implements CommandInterface
{
    /**
     * @var Command
     */
    private $command;

    public function configure(Command $command)
    {
        $this->command = $command;
        $command->setName('edit');
        $command->setDescription('Edit an existing donor');
        $command->setHelp('Register a new traditional printed mandate in database');
        $command->addOption('payer-number', null, InputOption::VALUE_REQUIRED, 'Unique payer identifier');
        $command->addOption('account', null, InputOption::VALUE_REQUIRED, 'Payer account number');
        $command->addOption('id', null, InputOption::VALUE_REQUIRED, 'Payer personal number or organisation number');
        $command->addOption('name', null, InputOption::VALUE_REQUIRED, 'Payer name');
        $command->addOption('address1', null, InputOption::VALUE_OPTIONAL, 'Address field 1');
        $command->addOption('address2', null, InputOption::VALUE_OPTIONAL, 'Address field 2');
        $command->addOption('postal-code', null, InputOption::VALUE_OPTIONAL, 'Postal code');
        $command->addOption('postal-city', null, InputOption::VALUE_OPTIONAL, 'Postal city');
        $command->addOption('co-address', null, InputOption::VALUE_OPTIONAL, 'C/o address');
        $command->addOption('email', null, InputOption::VALUE_OPTIONAL, 'Contact email address');
        $command->addOption('phone', null, InputOption::VALUE_OPTIONAL, 'Contact phone number');
        $command->addOption('amount', null, InputOption::VALUE_OPTIONAL, 'Monthly donation amount');
        $command->addOption('comment', null, InputOption::VALUE_OPTIONAL, 'Comment');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $donorBuilder = $container->get('donor_builder');
        $donorMapper = $container->get('donor_mapper');
        $accountFactory = $container->get('account_factory');
        $idFactory = $container->get('id_factory');

        $donor = $donorMapper->findByActivePayerNumber(
            $payerNumber = $this->getProperty('payer-number', 'Unique ID number for donor', '', $input, $output)
        );

        $output->writeln('personal Id: ' . $donor->getDonorId());
        $output->writeln('Account number: ' . $donor->getAccount());

        $this->setName(
            $this->getProperty('name', 'Donor name', $donor->getName(), $input, $output),
            $donor
        );
        $this->setPostalAddress(
            [
                'address1' => $this->getProperty(
                    'address1',
                    'Donor Address line 1',
                    $donor->getAddress()->getAddress1(),
                    $input,
                    $output
                ),
                'address2' => $this->getProperty(
                    'address2',
                    'Donor Address line 2',
                    $donor->getAddress()->getAddress2(),
                    $input,
                    $output
                ),
                'postalCode' => $this->getProperty(
                    'postal-code',
                    'Donor Postal code',
                    $donor->getAddress()->getPostalCode(),
                    $input,
                    $output
                ),
                'postalCity' => $this-> getProperty(
                    'postal-city',
                    'Donor Address city',
                    $donor->getAddress()->getPostalCity(),
                    $input,
                    $output
                ),
                'coAddress' => $this->getProperty(
                    'co-address',
                    'C/o Address',
                    $donor->getAddress()->getCoAddress(),
                    $input,
                    $output
                ),
            ],
            $donor
        );
        $this->setEmail(
            $this->getProperty('email', 'Contact email address', $donor->getEmail(), $input, $output),
            $donor
        );
        $this->setPhone(
            $this->getProperty('phone', 'Contact phone number', $donor->getPhone(), $input, $output),
            $donor
        );
        $this->setDonationAmount(
            $this->getProperty(
                'amount',
                'Monthly donation amount',
                $donor->getDonationAmount()->getAmount(),
                $input,
                $output
            ),
            $donor
        );
        $this->setComment(
            $this->getProperty('comment', 'Comment', $donor->getComment(), $input, $output),
            $donor
        );

        $donorMapper->save($donor);
        $container->get('event_dispatcher')->dispatch(
            Events::MANDATE_EDITED_EVENT,
            new DonorEvent("Edited donor", $donor)
        );
        $output->writeln('Donor edited');
    }

    private function getProperty(
        string $key,
        string $desc,
        string $default,
        InputInterface $input,
        OutputInterface $output
    ): string {
        $value = $input->getOption($key);

        if (!$value) {
            $value = $this->command->getHelper('question')->ask(
                $input,
                $output,
                new Question("$desc: [$default]", $default)
            );
        }
        return $value;
    }
    private function setName(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setName($value);
        } else {
            throw new \Exception('Donor needs a name');
        }
    }

    private function setPostalAddress(
        array $values,
        Donor $donor
    ) {
        if ($values) {
            $newPostalAddress = new PostalAddress(
                $values['postalCode'],
                $values['postalCity'],
                $values['address1'],
                $values['address2'],
                $values['coAddress']
            );

            $donor->setAddress($newPostalAddress);
        }
    }

    private function setEmail(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setEmail($value);
        }
    }

    private function setPhone(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setPhone($value);
        }
    }

    private function setDonationAmount(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $newDonationAmount = new SEK($value);
            $donor->setDonationAmount($newDonationAmount);
        }
    }

    private function setComment(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setComment($value);
        }
    }
}
