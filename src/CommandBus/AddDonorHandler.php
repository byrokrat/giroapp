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
use byrokrat\giroapp\Domain\NewDonorProcessor;
use byrokrat\giroapp\Event\DonorAdded;

final class AddDonorHandler
{
    use DependencyInjection\DispatcherProperty;
    use DependencyInjection\DonorRepositoryProperty;

    /** @var NewDonorProcessor */
    private $donorProcessor;

    public function __construct(NewDonorProcessor $donorProcessor)
    {
        $this->donorProcessor = $donorProcessor;
    }

    public function handle(AddDonor $command): void
    {
        $donor = $this->donorProcessor->processNewDonor($command->getNewDonor());

        $this->donorRepository->addNewDonor($donor);

        $this->dispatcher->dispatch(new DonorAdded($donor));
    }
}
