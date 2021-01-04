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
use byrokrat\giroapp\Event\DonorPayerNumberUpdated;
use byrokrat\giroapp\Workflow\Transitions;

final class UpdatePayerNumberHandler
{
    use DependencyInjection\CommandBusProperty;
    use DependencyInjection\DispatcherProperty;
    use DependencyInjection\DonorRepositoryProperty;

    public function handle(UpdatePayerNumber $command): void
    {
        $donor = $command->getDonor();

        $this->commandBus->handle(
            new UpdateAttribute($donor, 'old_payer_number', $donor->getPayerNumber())
        );

        $this->donorRepository->updateDonorPayerNumber($donor, $command->getNewPayerNumber());

        $this->dispatcher->dispatch(
            new DonorPayerNumberUpdated($donor, $command->getNewPayerNumber(), $command->getUpdateDescription())
        );

        $this->commandBus->handle(
            new UpdateState($donor, Transitions::INITIATE_PAYER_NUMBER_CHANGE, $command->getUpdateDescription())
        );
    }
}
