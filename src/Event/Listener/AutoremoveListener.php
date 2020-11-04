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

namespace byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\State\Revoked;
use byrokrat\giroapp\Event\DonorStateUpdated;

final class AutoremoveListener implements ListenerInterface
{
    use DependencyInjection\CommandBusProperty;

    /** @var ConfigInterface */
    private $autoremoveConfig;

    public function __construct(ConfigInterface $autoremoveConfig)
    {
        $this->autoremoveConfig = $autoremoveConfig;
    }

    public function __invoke(DonorStateUpdated $event): void
    {
        if ($event->getNewState()::getStateId() == Revoked::getStateId()
            && !!$this->autoremoveConfig->getValue()
        ) {
            $this->commandBus->handle(new CommandBus\ForceRemoveDonor($event->getDonor()));
        }
    }
}
