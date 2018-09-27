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

namespace byrokrat\giroapp\State;

use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Utils\SystemClock;

class TransactionDateFactory
{
    /**
     * Default day of month of created date
     */
    const DEFAULT_DAY_OF_MONTH = 28;

    /**
     * Default value for minimal number of days in the future
     */
    const DEFAULT_MIN_DAYS_IN_FUTURE = 4;

    /**
     * @var SystemClock
     */
    private $systemClock;

    /**
     * @var ConfigInterface
     */
    private $dayOfMonth;

    /**
     * @var ConfigInterface
     */
    private $minDaysInFuture;

    public function __construct(
        SystemClock $systemClock,
        ConfigInterface $dayOfMonth,
        ConfigInterface $minDaysInFuture
    ) {
        $this->systemClock = $systemClock;
        $this->dayOfMonth = $dayOfMonth;
        $this->minDaysInFuture = $minDaysInFuture;
    }

    /**
     * Calculate the date of next possible transaction date based on requested day of month
     */
    public function createNextTransactionDate(): \DateTimeImmutable
    {
        $currentDate = $this->systemClock->getNow();

        $createdDate = new \DateTime($currentDate->format('Ym') . $this->getDayOfMonth());

        if ($createdDate->diff($currentDate)->format('%d') < $this->getMinDaysInFuture()) {
            $createdDate->add(new \DateInterval('P1M'));
        }

        return \DateTimeImmutable::createFromMutable($createdDate);
    }

    private function getDayOfMonth(): int
    {
        return (int)$this->dayOfMonth->getValue() ?: self::DEFAULT_DAY_OF_MONTH;
    }

    private function getMinDaysInFuture(): int
    {
        return (int)$this->minDaysInFuture->getValue() ?: self::DEFAULT_MIN_DAYS_IN_FUTURE;
    }
}
