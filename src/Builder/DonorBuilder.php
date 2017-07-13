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
use byrokrat\giroapp\Model\DonorState\DonorState;
use byrokrat\giroapp\Model\DonorState\NewMandateState;
use byrokrat\giroapp\Model\DonorState\NewDigitalMandateState;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\id\Id;
use byrokrat\banking\AccountNumber;
use byrokrat\amount\Currency\SEK;

/**
 * Build donors from input
 */
class DonorBuilder
{
    /**
     * @var MandateKeyBuilder
     */
    private $keyBuilder;

    /**
     * @var string
     */
    private $mandateSource = Donor::MANDATE_SOURCE_PAPER;

    /**
     * @var string
     */
    private $payerNumber;

    /**
     * @var Id
     */
    private $id;

    /**
     * @var AccountNumber
     */
    private $account;

    /**
     * @var string
     */
    private $name;

    /**
     * @var PostalAddress
     */
    private $postalAddress;

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $phone = '';

    /**
     * @var string
     */
    private $comment = '';

    /**
     * @var SEK
     */
    private $donationAmount;

    public function __construct(MandateKeyBuilder $keyBuilder)
    {
        $this->keyBuilder = $keyBuilder;
    }

    /**
     * Use one of the donor mandate source constants
     */
    public function setMandateSource(string $mandateSource): self
    {
        $this->mandateSource = $mandateSource;
        return $this;
    }

    public function setPayerNumber(string $payerNumber): self
    {
        $this->payerNumber = $payerNumber;
        return $this;
    }

    public function setId(Id $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setAccount(AccountNumber $account): self
    {
        $this->account = $account;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setPostalAddress(PostalAddress $postalAddress): self
    {
        $this->postalAddress = $postalAddress;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function setDonationAmount(SEK $amount): self
    {
        $this->donationAmount = $amount;
        return $this;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function buildDonor(): Donor
    {
        return new Donor(
            $this->keyBuilder->buildKey($this->getId(), $this->getAccount()),
            $this->getState(),
            $this->mandateSource,
            $this->getPayerNumber(),
            $this->getAccount(),
            $this->getId(),
            $this->getName(),
            $this->getPostalAddress(),
            $this->email,
            $this->phone,
            $this->getDonationAmount(),
            $this->comment
        );
    }

    private function getId(): Id
    {
        if (isset($this->id)) {
            return $this->id;
        }

        throw new \RuntimeException('Unable to build Donor, id not set');
    }

    private function getAccount(): AccountNumber
    {
        if (isset($this->account)) {
            return $this->account;
        }

        throw new \RuntimeException('Unable to build Donor, account not set');
    }

    private function getState(): DonorState
    {
        if (isset($this->state)) {
            return $this->state;
        }

        switch ($this->mandateSource) {
            case Donor::MANDATE_SOURCE_PAPER:
                return new NewMandateState;
            case Donor::MANDATE_SOURCE_DIGITAL:
                return new NewDigitalMandateState;
        }

        throw new \RuntimeException('Unable to build donor, invalid donor state');
    }

    private function getPayerNumber(): string
    {
        if (isset($this->payerNumber)) {
            return $this->payerNumber;
        }

        return $this->getId()->format('Ssk');
    }

    private function getName(): string
    {
        if (isset($this->name)) {
            return $this->name;
        }

        throw new \RuntimeException('Unable to build Donor, name not set');
    }

    private function getPostalAddress(): PostalAddress
    {
        return $this->postalAddress ?: new PostalAddress('', '', '', '', '');
    }

    private function getDonationAmount(): SEK
    {
        return $this->donationAmount ?: new SEK('0');
    }
}
