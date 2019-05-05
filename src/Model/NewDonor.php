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

namespace byrokrat\giroapp\Model;

use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use byrokrat\amount\Currency\SEK;

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

    /** @var string */
    private $name;

    /** @var PostalAddress */
    private $address;

    /** @var string */
    private $email;

    /** @var string */
    private $phone;

    /** @var SEK */
    private $donationAmount;

    /** @var string */
    private $comment;

    /** @var string[] */
    private $attributes;

    /**
     * @param string[] $attributes
     */
    public function __construct(
        string $mandateSource,
        string $payerNumber,
        AccountNumber $account,
        IdInterface $donorId,
        string $name,
        PostalAddress $address,
        string $email,
        string $phone,
        SEK $donationAmount,
        string $comment,
        array $attributes = []
    ) {
        $this->mandateSource = $mandateSource;
        $this->payerNumber = $payerNumber;
        $this->account = $account;
        $this->donorId = $donorId;
        $this->name = $name;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
        $this->donationAmount = $donationAmount;
        $this->comment = $comment;
        $this->attributes = $attributes;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getPostalAddress(): PostalAddress
    {
        return $this->address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getDonationAmount(): SEK
    {
        return $this->donationAmount;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return string[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
