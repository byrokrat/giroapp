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

namespace byrokrat\giroapp\Event;

use byrokrat\giroapp\Domain\Donor;
use Money\Money;

final class DonorAmountUpdated extends DonorEvent
{
    /** @var Money */
    private $newAmount;

    public function __construct(Donor $donor, Money $newAmount)
    {
        parent::__construct("Changed amount on mandate '{$donor->getMandateKey()}'", $donor);
        $this->newAmount = $newAmount;
    }

    public function getNewAmount(): Money
    {
        return $this->newAmount;
    }
}
