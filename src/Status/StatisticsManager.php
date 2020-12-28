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

namespace byrokrat\giroapp\Status;

use byrokrat\giroapp\Exception\InvalidStatisticException;

class StatisticsManager
{
    /** @var array<string, StatisticInterface> */
    private $statistics = [];

    public function addStatistic(StatisticInterface $statistic): void
    {
        $this->statistics[$statistic->getName()] = $statistic;
    }

    public function getStatistic(string $name): StatisticInterface
    {
        if (!isset($this->statistics[$name])) {
            throw new InvalidStatisticException("Unknown statistic '$name'");
        }

        return $this->statistics[$name];
    }

    /** @return array<string, StatisticInterface> */
    public function getAllStatistics(): array
    {
        return $this->statistics;
    }
}
