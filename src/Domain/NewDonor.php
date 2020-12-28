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

declare(strict_types=1);

namespace byrokrat\giroapp\Domain;

use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use Money\Money;

class NewDonor
{
    /** @var string */
    private $mandateSource;

    /** @var string */
    private $payerNumber;

    /** @var AccountNumber */
    private $account;

    /** @var IdInterface */
    private $donorId;

    /** @var Money */
    private $donationAmount;

    public function __construct(
        string $mandateSource,
        string $payerNumber,
        AccountNumber $account,
        IdInterface $donorId,
        Money $donationAmount
    ) {
        $this->mandateSource = $mandateSource;
        $this->payerNumber = $payerNumber;
        $this->account = $account;
        $this->donorId = $donorId;
        $this->donationAmount = $donationAmount;
    }

    public function getMandateSource(): string
    {
        return $this->mandateSource;
    }

    public function getPayerNumber(): string
    {
        return $this->payerNumber;
    }

    public function getAccount(): AccountNumber
    {
        return $this->account;
    }

    public function getDonorId(): IdInterface
    {
        return $this->donorId;
    }

    public function getDonationAmount(): Money
    {
        return $this->donationAmount;
    }
}
