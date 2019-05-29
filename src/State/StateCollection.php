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

use byrokrat\giroapp\Utils\ClassIdExtractor;
use byrokrat\giroapp\Utils\CollectionTrait;

class StateCollection
{
    use CollectionTrait;

    protected function describeItem(): string
    {
        return 'State';
    }

    public function addState(StateInterface $state): void
    {
        $this->addItem($state->getStateId(), $state);
    }

    public function getState(string $stateId): StateInterface
    {
        if ($this->hasItem($stateId)) {
            return $this->getItem($stateId);
        }

        return $this->getItem((string)(new ClassIdExtractor($stateId)));
    }
}
