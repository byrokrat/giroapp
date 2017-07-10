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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use byrokrat\autogiro\Writer\WriterFactory;
use byrokrat\banking\BankgiroFactory;

/**
 * Command to create autogiro files
 */
class ExportCommand implements CommandInterface
{
    public function configure(Command $command)
    {
        $command->setName('export');
        $command->setDescription('Export a file to autogirot');
        $command->setHelp('Create a file with new set of autogiro actions');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $settings = $container->get('settings_mapper');

        $writer = (new WriterFactory)->createWriter(
            $settings->read('bgc_customer_number'),
            (new BankgiroFactory)->createAccount($settings->read('bankgiro'))
        );

        $donorMapper = $container->get('donor_mapper');

        foreach ($donorMapper->findAll() as $donor) {
            $donor->exportToAutogiro($writer);
            $donorMapper->save($donor);
        }

        $output->write($writer->getContent());
    }
}
