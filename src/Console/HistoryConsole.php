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

declare(strict_types=1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DonorEventStoreProperty;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class HistoryConsole implements ConsoleInterface
{
    use Helper\DonorArgument;
    use DonorEventStoreProperty;

    private const TYPE_FILTER = [
        'attributes' => [
            'DONOR_ATTRIBUTE_REMOVED',
            'DONOR_ATTRIBUTE_UPDATED',
        ],
        'info' => [
            'DONOR_EMAIL_UPDATED',
            'DONOR_PHONE_UPDATED',
            'DONOR_POSTAL_ADDRESS_UPDATED',
            'DONOR_COMMENT_UPDATED',
            'DONOR_NAME_UPDATED',
        ],
        'state' => [
            'DONOR_ADDED',
            'DONOR_STATE_UPDATED',
            'DONOR_REMOVED',
            'DONOR_PAYER_NUMBER_UPDATED',
            'DONOR_AMOUNT_UPDATED',
        ],
        'transactions' => [
            'TRANSACTION_FAILED',
            'TRANSACTION_PERFORMED',
        ],
    ];

    public function configure(Command $command): void
    {
        $command
            ->setName('history')
            ->setDescription('Inspect donor history')
            ->setHelp('Display event log information associated with donor')
            ->addOption('attributes', null, InputOption::VALUE_NONE, 'Show attribute history')
            ->addOption('info', null, InputOption::VALUE_NONE, 'Show info history')
            ->addOption('state', null, InputOption::VALUE_NONE, 'Show state history')
            ->addOption('transactions', null, InputOption::VALUE_NONE, 'Show transaction history')
            ->addOption(
                'type',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Show entries matching custom type'
            )
        ;

        $this->configureDonorArgument($command);
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->readDonor($input);

        $filterOnTypes = [];

        foreach (self::TYPE_FILTER as $option => $types) {
            if ($input->getOption($option)) {
                $filterOnTypes = array_merge($filterOnTypes, $types);
            }
        }

        if ($input->getOption('type')) {
            $filterOnTypes = array_merge($filterOnTypes, (array)$input->getOption('type'));
        }

        foreach ($this->donorEventStore->readEntriesForMandateKey($donor->getMandateKey()) as $entry) {
            if (empty($filterOnTypes) || in_array($entry->getType(), $filterOnTypes)) {
                $output->writeln(
                    sprintf(
                        "[%s] %-28s %s",
                        $entry->getDateTime()->format('Y-m-d H:i:s'),
                        $entry->getType(),
                        json_encode($entry->getData())
                    )
                );
            }
        }
    }
}
