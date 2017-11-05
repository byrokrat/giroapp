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
use byrokrat\giroapp\States;
use byrokrat\amount\Currency\SEK;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to display database status
 */
class StatusCommand implements CommandInterface
{
    /**
     * @var DonorMapper
     */
    private $donorMapper;

    public function __construct(DonorMapper $donorMapper)
    {
        $this->donorMapper = $donorMapper;
    }

    public static function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('status');
        $wrapper->setDescription('Show current status');
        $wrapper->setHelp('Examine the status of the giroapp database');
        $wrapper->discardOutputMessages();
        $wrapper->addOption('donor-count', null, InputOption::VALUE_NONE, 'Show only donor count');
        $wrapper->addOption('active-donor-count', null, InputOption::VALUE_NONE, 'Show only active donor count');
        $wrapper->addOption('exportable-count', null, InputOption::VALUE_NONE, 'Show only exportable count');
        $wrapper->addOption('monthly-amount', null, InputOption::VALUE_NONE, 'Show only monthly amount');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $counts = [
            'donor-count' => 0,
            'active-donor-count' => 0,
            'exportable-count' => 0,
            'monthly-amount' => new SEK('0')
        ];

        foreach ($this->donorMapper->findAll() as $donor) {
            $counts['donor-count']++;

            if ($donor->getState()->getStateId() == States::ACTIVE) {
                $counts['monthly-amount'] = $counts['monthly-amount']->add($donor->getDonationAmount());
                $counts['active-donor-count']++;
            }

            if ($donor->getState()->isExportable()) {
                $counts['exportable-count']++;
            }
        }

        $counts['monthly-amount'] = $counts['monthly-amount']->getString(0);

        foreach (array_keys($counts) as $key) {
            if ($input->getOption($key)) {
                $output->writeln($counts[$key]);
                return;
            }
        }

        $output->writeln("Donors: {$counts['donor-count']}");
        $output->writeln("Active: {$counts['active-donor-count']}");
        $highlight = $counts['exportable-count'] ? 'error' : 'info';
        $output->writeln("<$highlight>Exportables: {$counts['exportable-count']}</$highlight>");
        $output->writeln("Monthly amount: {$counts['monthly-amount']}");
    }
}
