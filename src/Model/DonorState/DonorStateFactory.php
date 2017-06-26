<?php
/**
 * This file is part of byrokrat\giroapp\State.
 *
 * byrokrat\giroapp\State is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * byrokrat\giroapp\State is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with byrokrat\giroapp\State. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Model\DonorState;

/**
 * Handles the creation of state objects
 */
class DonorStateFactory
{
    /**
     * @throws \RuntimeException If state id is unknown
     */
    public function createDonorState(string $stateId): DonorState
    {
        if (!class_exists($stateId)) {
            throw new \RuntimeException("Unknown state id $stateId");
        }

        $state = new $stateId;

        if (!$state instanceof DonorState) {
            throw new \RuntimeException("Unvalid state id $stateId");
        }

        return $state;
    }
}