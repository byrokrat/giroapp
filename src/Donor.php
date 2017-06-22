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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp;

use byrokrat\giroapp\State\State;
use byrokrat\autogiro\Writer;

/**
 * Models an individual donor
 */
class Donor
{
    /**
     * Indicator that mandate exists printed on paper
     */
    const MANDATE_SOURCE_PAPER = 'MANDATE_SOURCE_PAPER';

    /**
     * Indicator that mandate is digital
     */
    const MANDATE_SOURCE_DIGITAL = 'MANDATE_SOURCE_DIGITAL';

    /**
     * @var State
     */
    private $state;

    /**
     * @var string
     */
    private $mandateSource;

    public function __construct(State $state, string $mandateSource)
    {
        $this->setState($state);
        $this->mandateSource = $mandateSource;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function setState(State $state)
    {
        $this->state = $state;
    }

    public function getMandateSource(): string
    {
        return $this->mandateSource;
    }

    public function exportToAutogiro(Writer $writer)
    {
        $this->getState()->export($this, $writer);
    }
}
