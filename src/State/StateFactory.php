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

namespace byrokrat\giroapp\State;

use byrokrat\giroapp\States;

/**
 * Handles the creation of state objects
 */
class StateFactory
{
    /**
     * Map state identifier to class name
     */
    private static $stateToClassMap = [
        States::ACTIVE              => ActiveState::CLASS,
        States::ERROR               => ErrorState::CLASS,
        States::INACTIVE            => InactiveState::CLASS,
        States::NEW_MANDATE         => NewMandateState::CLASS,
        States::NEW_DIGITAL_MANDATE => NewDigitalMandateState::CLASS,
        States::MANDATE_SENT        => MandateSentState::CLASS,
        States::MANDATE_APPROVED    => MandateApprovedState::CLASS,
        States::REVOKE_MANDATE      => RevokeMandateState::CLASS,
        States::REVOCATION_SENT     => RevocationSentState::CLASS,
    ];

    /**
     * @throws \RuntimeException If state id is unknown
     */
    public function createState(string $stateId): StateInterface
    {
        $stateId = strtoupper($stateId);

        if (!isset(self::$stateToClassMap[$stateId])) {
            throw new \RuntimeException("Unknown state id $stateId");
        }

        return new self::$stateToClassMap[$stateId];
    }
}
