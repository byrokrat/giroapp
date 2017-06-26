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

namespace byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\DonorState\DonorState;
use byrokrat\autogiro\Writer\Writer;

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
     * @var DonorState
     */
    private $state;

    /**
     * @var string
     */
    private $mandateSource;

    /**
     * @var string
     */
    private $payerNumber;

    /**
     * @var \byrokrat\banking\AccountNumber
     */
    private $account;

    /**
     * @var \byrokrat\id\Id
     */
    private $id;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var string
     */
    private $namn;

    /**
     * @var string
     */
    private $adress1;

    /**
     * @var string
     */
    private $adress2;

    /**
     * @var string
     */
    private $adress3;

    /**
     * @var string
     */
    private $postNummer;

    /**
     * @var string
     */
    private $postAdress;


    public function __construct(DonorState $state, string $mandateSource)
    {
        $this->setState($state);
        $this->mandateSource = $mandateSource;
    }

    public function getState(): DonorState
    {
        return $this->state;
    }

    public function setState(DonorState $state)
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
