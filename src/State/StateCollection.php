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
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\State;

use byrokrat\giroapp\Utils\ContainerTrait;

class StateCollection
{
    use ContainerTrait;

    public function __construct(
        ActiveState $active,
        ErrorState $error,
        InactiveState $inactive,
        NewMandateState $newMandate,
        NewDigitalMandateState $newDigitalMandate,
        MandateSentState $mandateSent,
        MandateApprovedState $mandateApproved,
        RevokeMandateState $revokeMandate,
        RevocationSentState $revocationSent,
        PauseMandateState $pauseMandate,
        PauseSentState $pauseSent,
        PausedState $paused
    ) {
        $this->addState($active);
        $this->addState($error);
        $this->addState($inactive);
        $this->addState($newMandate);
        $this->addState($newDigitalMandate);
        $this->addState($mandateSent);
        $this->addState($mandateApproved);
        $this->addState($revokeMandate);
        $this->addState($revocationSent);
        $this->addState($pauseMandate);
        $this->addState($pauseSent);
        $this->addState($paused);
    }

    public function addState(StateInterface $state): void
    {
        $this->addItem($state->getStateId(), $state);
    }

    public function getState(string $stateId): StateInterface
    {
        return $this->getItem($stateId);
    }
}
