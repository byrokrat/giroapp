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

namespace byrokrat\giroapp\Event;

use byrokrat\giroapp\Domain\Donor;

abstract class DonorEvent extends InfoEvent
{
    /** @var Donor */
    private $donor;

    /**
     * @param array<string> $context
     */
    public function __construct(string $message, Donor $donor, array $context = [])
    {
        $context['mandate_key'] = $donor->getMandateKey();

        parent::__construct($message, $context);

        $this->donor = $donor;
    }

    public function getDonor(): Donor
    {
        return $this->donor;
    }
}
