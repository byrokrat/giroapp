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

namespace byrokrat\giroapp\Event;

use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\StateInterface;

class DonorStateUpdated extends DonorEvent
{
    /** @var StateInterface */
    private $newState;

    /** @var string */
    private $desc;

    public function __construct(Donor $donor, StateInterface $newState, string $desc)
    {
        parent::__construct(
            sprintf(
                "Changed state on mandate '%s' to '%s'",
                $donor->getMandateKey(),
                $newState->getStateId()
            ),
            $donor
        );

        $this->newState = $newState;
        $this->desc = $desc;
    }

    public function getNewState(): StateInterface
    {
        return $this->newState;
    }

    public function getUpdateDescription(): string
    {
        return $this->desc;
    }
}
