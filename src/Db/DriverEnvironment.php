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
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Db;

use byrokrat\giroapp\Domain\DonorFactory;
use byrokrat\giroapp\Utils\SystemClock;
use Money\MoneyFormatter;

/**
 * The environment in which a database driver is invoked
 */
class DriverEnvironment
{
    /** @var SystemClock */
    private $clock;

    /** @var DonorFactory */
    private $donorFactory;

    /** @var MoneyFormatter */
    private $moneyFormatter;

    public function __construct(SystemClock $clock, DonorFactory $donorFactory, MoneyFormatter $moneyFormatter)
    {
        $this->clock = $clock;
        $this->donorFactory = $donorFactory;
        $this->moneyFormatter = $moneyFormatter;
    }

    public function getClock(): SystemClock
    {
        return $this->clock;
    }

    public function getDonorFactory(): DonorFactory
    {
        return $this->donorFactory;
    }

    public function getMoneyFormatter(): MoneyFormatter
    {
        return $this->moneyFormatter;
    }
}
