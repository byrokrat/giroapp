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
 * Copyright 2016-18 Hannes Forsgård
 */

namespace byrokrat\giroapp\State;

use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\WriterInterface;

/**
 * Defines a donor state in relation to bgc
 */
interface StateInterface
{
    /**
     * Get state identifier
     */
    public function getStateId(): string;

    /**
     * Get identifier of next state in a state chain (eg. after export)
     */
    public function getNextStateId(): string;

    /**
     * Get free text state description
     */
    public function getDescription(): string;

    /**
     * Export to autogiro and possibly perform state transition
     */
    public function export(Donor $donor, WriterInterface $writer): void;

    /**
     * Check if a donor with this state is an active donor
     */
    public function isActive(): bool;

    /**
     * Check if a donor with this state is expecting a response from autogirot
     */
    public function isAwaitingResponse(): bool;

    /**
     * Check if a donor with this state is broken
     */
    public function isError(): bool;

    /**
     * Check if a donor with this state is exportable to autogirot
     */
    public function isExportable(): bool;

    /**
     * Check if a donor with this state can be safely removed
     */
    public function isPurgeable(): bool;
}
