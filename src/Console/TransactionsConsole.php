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
 * Copyright 2016-20 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DonorEventStoreProperty;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TransactionsConsole implements ConsoleInterface
{
    use Helper\DonorArgument, DonorEventStoreProperty;

    public function configure(Command $command): void
    {
        $command->setName('transactions');
        $command->setAliases(['trans']);
        $command->setDescription('List transactions from donor');
        $command->setHelp('Display transactions information from a donor');
        $this->configureDonorArgument($command);
        $command->addOption('failed', null, InputOption::VALUE_NONE, 'Show failed transactions');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->readDonor($input);

        $type = $input->getOption('failed') ? 'TRANSACTION_FAILED' : 'TRANSACTION_PERFORMED';

        foreach ($this->donorEventStore->readEntriesForMandateKey($donor->getMandateKey()) as $entry) {
            if ($entry->getType() == $type) {
                $data = $entry->getData();
                $output->writeln(sprintf(
                    'SEK %s on %s',
                    $data['transaction_amount'] ?? '',
                    $data['transaction_date'] ?? ''
                ));
            }
        }
    }
}
