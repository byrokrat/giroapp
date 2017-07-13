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

namespace byrokrat\giroapp\Builder;

use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Builder\MandateKeyBuilder;
use byrokrat\giroapp\Builder\DateBuilder;

/**
 * Create Donor
 */
class DonorBuilder
{
    /**
     * @var MandateKeyBuilder
     */
    private $mandateKeyBuilder;

    /**
     * @var DateBuilder
     */
    private $dateBuilder;

    public function __construct() {
        $this->mandateKeyBuilder = new MandateKeyBuilder();
        $this->dateBuilder = new DateBuilder();
    }

    public function buildDonor(
        DonorState $state,
        string $mandateSource,
        string $payerNumber,
        AccountNumber $account,
        Id $donorId,
        string $name,
        PostalAddress $address = null,
        SEK $donationAmount = null,
        string $comment = "",
        int $dayOfMonth = -1,
        int $minDaysInFuture = -1 
    ) {
        $key = $this->mandateKeyBuilder->buildKey($donorId, $account);

        if ($dayOfMonth > -1) {
            $this->dateBuilder->setDayOfMonth($dayOfMonth);
        }
        if ($minDaysInFuture > -1) {
            $this->dateBuilder->setMinDaysInFuture($minDaysInFuture);
        }
        $date = $this->dateBuilder->bildDate();

        return new Donor(
            $key,
            $date,
            $state,
            $mandateSource,
            $payerNumber,
            $account,
            $donorId,
            $name,
            $address,
            $donationAmount,
            $comment
        );
    }

    public function getMandateKeyBuilder(): MandateKeyBuilder
    {
        return $this->mandateKeyBuilder;
    }

    public function setMandateKeyBuilder(MandateKeyBuilder $mandateKeyBuilder)
    {
        $this->mandateKeyBuilder = $mandateKeyBuilder;
    }

    public function getDateBuilder(): DateBuilder
    {
        return $this->dateBuilder;
    }

    public function setDateBuilder(DateBuilder $dateBuilder)
    {
        $this->dateBuilder = $dateBuilder;
    }
}
