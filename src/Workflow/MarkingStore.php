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

namespace byrokrat\giroapp\Workflow;

use byrokrat\giroapp\CommandBus\ForceState;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\Domain\Donor;
use Symfony\Component\Workflow\MarkingStore\MarkingStoreInterface;
use Symfony\Component\Workflow\Marking;

final class MarkingStore implements MarkingStoreInterface
{
    use CommandBusProperty;

    public function getMarking(object $subject)
    {
        if (!$subject instanceof Donor) {
            throw new \InvalidArgumentException('MarkingStore expects a Donor subject');
        }

        $stateId = $subject->getState()->getStateId();

        return new Marking([$stateId => 1]);
    }

    /**
     * @param string[] $context
     * @return void
     */
    public function setMarking(object $subject, Marking $marking, array $context = [])
    {
        if (!$subject instanceof Donor) {
            throw new \InvalidArgumentException('MarkingStore expects a Donor subject');
        }

        /** @var string $place */
        $place = array_keys($marking->getPlaces())[0] ?? '';

        /** @var string $desc */
        $desc = $context['desc'] ?? '';

        $this->commandBus->handle(new ForceState($subject, $place, $desc));
    }
}
