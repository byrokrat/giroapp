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
 * Copyright 2016-21 Hannes Forsgård
 */

declare(strict_types=1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\State\AwaitingResponseStateInterface;
use byrokrat\giroapp\Domain\State\Active;
use byrokrat\giroapp\Domain\State\Error;
use byrokrat\giroapp\Domain\State\ExportableStateInterface;
use byrokrat\giroapp\Domain\State\Revoked;
use byrokrat\giroapp\Domain\State\Paused;
use byrokrat\giroapp\Status\StatisticsManager;
use Money\Money;
use Money\MoneyFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to display database status
 */
final class StatusConsole implements ConsoleInterface
{
    use DependencyInjection\DonorQueryProperty;
    use DependencyInjection\MoneyFormatterProperty;

    /** @var StatisticsManager */
    private $statisticsManager;

    public function __construct(StatisticsManager $statisticsManager)
    {
        $this->statisticsManager = $statisticsManager;
    }

    public function configure(Command $command): void
    {
        $command
            ->setName('status')
            ->setDescription('Show current status')
            ->setHelp('Examine the status of the giroapp database')
            ->addOption(
                'show',
                null,
                InputOption::VALUE_REQUIRED,
                'Show only named statistic (possible values include donor-count, '
                . 'monthly-amount, exportable-count, waiting-count, error-count, revoked-count and paused-count)'
            )
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'Show all statistics, including 0 values')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        /** @var string */
        $showOnly = $input->getOption('show');

        if ($showOnly) {
            $output->writeln((string)$this->statisticsManager->getStatistic($showOnly)->getValue());
            return;
        }

        foreach ($this->statisticsManager->getAllStatistics() as $statistic) {
            if ($statistic->getValue() == 0 && !$input->getOption('all')) {
                continue;
            }

            $output->writeln("{$statistic->getDescription()}: <comment>{$statistic->getValue()}</comment>");
        }
    }
}
