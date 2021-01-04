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

namespace byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Event\DonorStateUpdated;
use byrokrat\giroapp\Domain\State\StateCollection;

final class ForceStateHandler
{
    use DependencyInjection\DispatcherProperty;
    use DependencyInjection\DonorRepositoryProperty;

    /** @var StateCollection */
    private $stateCollection;

    public function __construct(StateCollection $stateCollection)
    {
        $this->stateCollection = $stateCollection;
    }

    public function handle(ForceState $command): void
    {
        $donor = $command->getDonor();

        $newState = $this->stateCollection->getState($command->getNewStateId());

        if ($newState::getStateId() == $donor->getState()::getStateId()) {
            return;
        }

        $this->donorRepository->updateDonorState($donor, $newState);

        $this->dispatcher->dispatch(
            new DonorStateUpdated($donor, $newState, $command->getUpdateDescription())
        );
    }
}
