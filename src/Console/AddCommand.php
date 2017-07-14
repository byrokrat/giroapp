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
                'payerNumber' => $this->getProperty('payerNumber', 'Unique ID number for donor', $input, $output),
                'accountNumber' => $this->getProperty('accountNumber', 'Donor account number', $input, $output),
                'donorId' => $this->getProperty('donorId', 'Donor personal id number or organisation number', $input, $output),
                'name' => $this->getProperty('name', 'Donor name', $input, $output),
                'address1' => $this->getProperty('address1', 'Address field 1', $input, $output),
                'address2' => $this->getProperty('address2', 'Address field 2', $input, $output),
                'postalCode' => $this->getProperty('postalCode', 'Postal code', $input, $output),
                'postalCity' => $this->getProperty('postalCity', 'Postal city', $input, $output),
                'coAddress' => $this->getProperty('coAddress', 'C/o address', $input, $output),
                'email' => $this->getProperty('email', 'Contact email address', $input, $output),
                'phone' => $this->getProperty('phone', 'Contact phone number', $input, $output),
                'donationAmount' => $this->getProperty('donationAmount', 'Monthly donation amount', $input, $output),
                'comment' => $this->getProperty('comment', 'Comment', $input, $output)
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
        $newValue = $input->getOption(str_replace('_', '-', $key));

        if (!$newValue) {
            $newValue = $this->command->getHelper('question')->ask(
                    $input,
                    $output,
                    new Question("$desc: ", '')
                );
        }

        return ['desc' => $desc, 'value' => $newValue];
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
                $donor['payerNumber']['value'],
                $donor['accountNumber']['value'],
                $donor['donorId']['value'],
                $donor['name']['value'],
                [
                    $donor['address1']['value'],
                    $donor['address2']['value'],
                    $donor['postalCode']['value'],
                    $donor['postalCity']['value'],
                    $donor['coAddress']['value']
                ],
                $donor['email']['value'],
                $donor['phone']['value'],
                $donor['donationAmount']['value'],
                $donor['comment']['value']
            )
        );
         */

        $output->writeln("\nAdded donor:\n");
        foreach ($donor as $key => $value) {
            if ($value['value']) {
                $output->writeln("{$value['desc']} <info>{$value['value']}</info>");
            }
        }
    }
}
