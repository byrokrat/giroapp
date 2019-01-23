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
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\State;

use byrokrat\giroapp\States;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\WriterInterface;

class PauseMandateState extends AbstractState
{
    public function getDescription(): string
    {
        return 'Mandate is awaiting to be paused';
    }

    public function getStateId(): string
    {
        return States::PAUSE_MANDATE;
    }

    public function getNextStateId(): string
    {
        return States::PAUSE_SENT;
    }

    public function export(Donor $donor, WriterInterface $writer): void
    {
        $writer->deletePayments($donor->getPayerNumber());
    }
}
