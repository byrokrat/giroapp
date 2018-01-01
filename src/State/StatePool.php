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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\State;

use byrokrat\giroapp\States;

/**
 * Collection of state objects
 */
class StatePool
{
    /**
     * @var array
     */
    private $pool;

    public function __construct(
        ActiveState $active,
        ErrorState $error,
        InactiveState $inactive,
        NewMandateState $newMandate,
        NewDigitalMandateState $newDigitalMandate,
        MandateSentState $mandateSent,
        MandateApprovedState $mandateApproved,
        RevokeMandateState $revokeMandate,
        RevocationSentState $revocationSent
    ) {
        $this->pool = [
            States::ACTIVE              => $active,
            States::ERROR               => $error,
            States::INACTIVE            => $inactive,
            States::NEW_MANDATE         => $newMandate,
            States::NEW_DIGITAL_MANDATE => $newDigitalMandate,
            States::MANDATE_SENT        => $mandateSent,
            States::MANDATE_APPROVED    => $mandateApproved,
            States::REVOKE_MANDATE      => $revokeMandate,
            States::REVOCATION_SENT     => $revocationSent,
        ];
    }

    /**
     * @throws \RuntimeException If state id is unknown
     */
    public function getState(string $stateId): StateInterface
    {
        $stateId = strtoupper($stateId);

        if (!isset($this->pool[$stateId])) {
            throw new \RuntimeException("Unknown state id $stateId");
        }

        return $this->pool[$stateId];
    }
}
