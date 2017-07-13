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

/**
 * Command to add a new mandate
 */
class AddCommand implements CommandInterface
{
    public function configure(Command $command)
    {
        $command->setName('add');
        $command->setDescription('Add a new donor');
        $command->setHelp('Register a new traditional printed mandate in database');
        $command->addOption('payerNumber', null, InputOption::VALUE_REQUIRED, 'Unique identifier number for the donor');
        $command->addOption('accountNumber', null, InputOption::VALUE_REQUIRED, 'Payer account number');
        $command->addOption('donorId', null, InputOption::VALUE_REQUIRED, 'Payer personal number or organisation number');
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
        $donorMapper = $container->get('donor_mapper');
        $donorBuilder = $container->get('donor_builder');
        $this->addDonor(
            [
                $this->getProperty('payerNumber', 'Unique ID number for donor', $input, $output),
                $this->getProperty('accountNumber', 'Donor account number', $input, $output),
                $this->getProperty('donorId', 'Donor personal id number or organisation number', $input, $output),
                $this->getProperty('name', 'Donor name', $input, $output),
                $this->getProperty('address1', 'Address field 1', $input, $output),
                $this->getProperty('address2', 'Address field 2', $input, $output),
                $this->getProperty('postalCode', 'Postal code', $input, $output),
                $this->getProperty('postalCity', 'Postal city', $input, $output),
                $this->getProperty('coAddress', 'C/o address', $input, $output),
                $this->getProperty('email', 'Contact email address', $input, $output),
                $this->getProperty('phone', 'Contact phone number', $input, $output),
                $this->getProperty('donationAmount', 'Monthly donation amount', $input, $output),
                $this->getProperty('comment', 'Comment', $input, $output)
            ],
            $input,
            $output
            //$donorMapper,
            //$donorBuilder
        );
    }

    private function getProperty(
        string $key,
        string $desc,
        InputInterface $input,
        OutputInterface $output
    ) {
        return $input->getOption(str_replace('_', '-', $key));
    }

    private function addDonor(
        array $donor,
        InputInterface $input,
        OutputInterface $output
        //DonorBuilder $donorBuilder,
        //DonorMapper $donorMapper
    ) {
        /**
         * Waiting on the DonorBuilder interface
        $donorMapper->save(
            $donorBuilder->buildDonor(
                $donor['payerNumber'],
                $donor['accountNumber'],
                $donor['donorId'],
                $donor['name'],
                [
                    $donor['address1'],
                    $donor['address2'],
                    $donor['postalCode'],
                    $donor['postalCity'],
                    $donor['coAddress']
                ],
                $donor['email'],
                $donor['phone'],
                $donor['donationAmount'],
                $donor['comment']
            )
        );
         */

        $output->writeln("Added donor:");
        $output->writeln("Name <info>{$donor['name']}</info>");
        $output->writeln("Payer number <info>{$donor['payerNumber']}</info>");
        $output->writeln("Account number <info>{$donor['accountNumber']}</info>");
        $output->writeln("Donor Id number <info>{$donor['donorId']}</info>");
        $output->writeln("Address:");
        $output->writeln("<info>{$donor['Address1']}</info>");
        $output->writeln("<info>{$donor['Address2']}</info>");
        $output->writeln("<info>{$donor['postalCode']}</info> <info>{$donor['postalCity']}");
        $output->writeln("c/o <info>{$donor['coAddress']}</info>");
        $output->writeln("Contact email address: <info>{$donor['email']}</info>");
        $output->writeln("Contact phone number: <info>{$donor['phone']}</info>");
        $output->writeln("Monthly donation amout: <info>{$donor['donationAmount']}</info>");
        $output->writeln("Comment: <info>{$donor['comment']}</info>");
    }
}
