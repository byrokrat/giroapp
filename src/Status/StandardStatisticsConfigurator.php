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

namespace byrokrat\giroapp\Status;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\State;

final class StandardStatisticsConfigurator
{
    use DependencyInjection\DonorQueryProperty;

    private const STAT_NAMES = [
        'donor-count' => 'Donors',
        'monthly-amount' => 'Monthly amount',
        'exportable-count' => 'Exportables',
        'waiting-count' => 'Awaiting response',
        'error-count' => 'Errors',
        'revoked-count' => 'Revoked',
        'paused-count' => 'Paused',
    ];

    /** @var array<string, int> */
    private $stats;

    public function loadStatistics(StatisticsManager $statisticsManager): void
    {
        foreach (self::STAT_NAMES as $name => $desc) {
            $statisticsManager->addStatistic(
                new LazyStatistic(
                    $name,
                    $desc,
                    function () use ($name) {
                        return $this->getStat($name);
                    }
                )
            );
        }
    }

    private function getStat(string $name): int
    {
        if (!isset($this->stats)) {
            $this->buildStats();
        }

        if (!isset($this->stats[$name])) {
            throw new \LogicException("Invalid internal stat $name");
        }

        return $this->stats[$name];
    }

    private function buildStats(): void
    {
        $this->stats = [
            'donor-count' => 0,
            'monthly-amount' => 0,
            'exportable-count' => 0,
            'waiting-count' => 0,
            'error-count' => 0,
            'revoked-count' => 0,
            'paused-count' => 0,
        ];

        foreach ($this->donorQuery->findAll() as $donor) {
            if ($donor->getState() instanceof State\Active) {
                $this->stats['donor-count']++;
                $this->stats['monthly-amount'] += intval($donor->getDonationAmount()->getAmount()) / 100;
            }

            if ($donor->getState() instanceof State\ExportableStateInterface) {
                $this->stats['exportable-count']++;
            }

            if ($donor->getState() instanceof State\AwaitingResponseStateInterface) {
                $this->stats['waiting-count']++;
            }

            if ($donor->getState() instanceof State\Error) {
                $this->stats['error-count']++;
            }

            if ($donor->getState() instanceof State\Revoked) {
                $this->stats['revoked-count']++;
            }

            if ($donor->getState() instanceof State\Paused) {
                $this->stats['paused-count']++;
            }
        }
    }
}
