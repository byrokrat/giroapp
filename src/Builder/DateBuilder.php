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

namespace byrokrat\giroapp\Builder;

use byrokrat\giroapp\Utils\SystemClock;

/**
 * Calculate the date of next possible transaction date based on requested day of month
 */
class DateBuilder
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
     * @var int
     */
    private $dayOfMonth;

    /**
     * @var int
     */
    private $minDaysInFuture;

    public function __construct(SystemClock $systemClock)
    {
        $this->systemClock = $systemClock;
    }

    /**
     * Set day of month of created date
     */
    public function setDayOfMonth(int $dayOfMonth): self
    {
        $this->dayOfMonth = $dayOfMonth;

        return $this;
    }

    /**
     * Set number of days in the future created dates must minimaly be in
     */
    public function setMinDaysInFuture(int $minDaysInFuture): self
    {
        $this->minDaysInFuture = $minDaysInFuture;

        return $this;
    }

    /**
     * Get next date for requested day of month
     */
    public function buildDate(): \DateTimeInterface
    {
        $currentDate = $this->systemClock->getNow();

        $createdDate =  new \DateTime($currentDate->format('Ym') . $this->getDayOfMonth());

        if ($createdDate->diff($currentDate)->format('%d') < $this->getMinDaysInFuture()) {
            $createdDate->add(new \DateInterval('P1M'));
        }

        return $createdDate;
    }

    private function getDayOfMonth(): int
    {
        return $this->dayOfMonth ?: self::DEFAULT_DAY_OF_MONTH;
    }

    private function getMinDaysInFuture(): int
    {
        return $this->minDaysInFuture ?: self::DEFAULT_MIN_DAYS_IN_FUTURE;
    }
}
