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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DonorMapperProperty;
use byrokrat\amount\Currency\SEK;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to display database status
 */
final class StatusCommand implements CommandInterface
{
    use DonorMapperProperty;

    public function configure(Adapter $wrapper): void
    {
        $wrapper->setName('status');
        $wrapper->setDescription('Show current status');
        $wrapper->setHelp('Examine the status of the giroapp database');
        $wrapper->addOption('donor-count', null, InputOption::VALUE_NONE, 'Show only active donor count');
        $wrapper->addOption('monthly-amount', null, InputOption::VALUE_NONE, 'Show only monthly amount');
        $wrapper->addOption('exportable-count', null, InputOption::VALUE_NONE, 'Show only exportable count');
        $wrapper->addOption('waiting-count', null, InputOption::VALUE_NONE, 'Show only awaiting response count');
        $wrapper->addOption('error-count', null, InputOption::VALUE_NONE, 'Show only error count');
        $wrapper->addOption('purgeable-count', null, InputOption::VALUE_NONE, 'Show only purgeable count');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $counts = [
            'donor-count' => 0,
            'monthly-amount' => new SEK('0'),
            'exportable-count' => 0,
            'waiting-count' => 0,
            'error-count' => 0,
            'purgeable-count' => 0,
        ];

        foreach ($this->donorMapper->findAll() as $donor) {
            if ($donor->getState()->isActive()) {
                $counts['donor-count']++;
                $counts['monthly-amount'] = $counts['monthly-amount']->add($donor->getDonationAmount());
            }

            if ($donor->getState()->isExportable()) {
                $counts['exportable-count']++;
            }

            if ($donor->getState()->isAwaitingResponse()) {
                $counts['waiting-count']++;
            }

            if ($donor->getState()->isError()) {
                $counts['error-count']++;
            }

            if ($donor->getState()->isPurgeable()) {
                $counts['purgeable-count']++;
            }
        }

        foreach (array_keys($counts) as $key) {
            if ($input->getOption($key)) {
                $output->writeln((string)$counts[$key]);
                return;
            }
        }

        $amount = number_format($counts['monthly-amount']->getFloat(), 0, ',', ' ');

        $output->writeln("<comment>Donors: {$counts['donor-count']}</comment>");
        $output->writeln("<comment>Monthly amount: $amount kr</comment>");
        $output->writeln($this->format('Exportables', $counts['exportable-count']));
        $output->writeln($this->format('Awaiting response', $counts['waiting-count']));
        $output->writeln($this->format('Errors', $counts['error-count']));
        $output->writeln($this->format('Purgeables', $counts['purgeable-count']));
    }

    private function format(string $desc, int $count): string
    {
        $tag = $count ? 'error' : 'info';
        return "<$tag>$desc: $count</$tag>";
    }
}
