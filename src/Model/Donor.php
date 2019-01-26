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

use byrokrat\giroapp\Exception\UnknownIdentifierException;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use byrokrat\amount\Currency\SEK;
use byrokrat\autogiro\Writer\WriterInterface;

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
     * Indicator that mandate is from an online form (eg. mandate from homepage)
     */
    const MANDATE_SOURCE_ONLINE_FORM = 'MANDATE_SOURCE_ONLINE_FORM';

    /**
     * Indicator that mandate is digital
     */
    const MANDATE_SOURCE_DIGITAL = 'MANDATE_SOURCE_DIGITAL';

    /**
     * @var string
     */
    private $mandateKey;

    /**
     * @var StateInterface
     */
    private $state;

    /**
     * @var string
     */
    private $stateDesc;

    /**
     * @var string
     */
    private $mandateSource;

    /**
     * @var string
     */
    private $payerNumber;

    /**
     * @var AccountNumber
     */
    private $account;

    /**
     * @var IdInterface
     */
    private $donorId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var PostalAddress
     */
    private $address;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var SEK
     */
    private $donationAmount;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var \DateTimeImmutable
     */
    private $created;

    /**
     * @var \DateTimeImmutable
     */
    private $updated;

    /**
     * @var array Loaded attributes
     */
    private $attributes;

    public function __construct(
        string $mandateKey,
        StateInterface $state,
        string $stateDesc,
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
        \DateTimeImmutable $created,
        \DateTimeImmutable $updated,
        array $attributes = []
    ) {
        $this->mandateKey = $mandateKey;
        $this->setState($state, $stateDesc);
        $this->mandateSource = $mandateSource;
        $this->setPayerNumber($payerNumber);
        $this->account = $account;
        $this->donorId = $donorId;
        $this->setName($name);
        $this->setPostalAddress($address);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setDonationAmount($donationAmount);
        $this->setComment($comment);
        $this->created = $created;
        $this->setUpdated($updated);
        $this->attributes = $attributes;
    }

    public function getMandateKey(): string
    {
        return $this->mandateKey;
    }

    public function getState(): StateInterface
    {
        return $this->state;
    }

    public function getStateDesc(): string
    {
        return $this->stateDesc;
    }

    public function setState(StateInterface $state, string $stateDesc = ''): void
    {
        $this->state = $state;
        $this->stateDesc = $stateDesc ?: $state->getDescription();
    }

    public function getMandateSource(): string
    {
        return $this->mandateSource;
    }

    public function getPayerNumber(): string
    {
        return $this->payerNumber;
    }

    public function setPayerNumber(string $payerNumber): void
    {
        $this->payerNumber = $payerNumber;
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPostalAddress(): PostalAddress
    {
        return $this->address;
    }

    public function setPostalAddress(PostalAddress $address): void
    {
        $this->address = $address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getDonationAmount(): SEK
    {
        return $this->donationAmount;
    }

    public function setDonationAmount(SEK $donationAmount): void
    {
        $this->donationAmount = $donationAmount;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getCreated(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated(): \DateTimeImmutable
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeImmutable $updated): void
    {
        $this->updated = $updated;
    }

    public function exportToAutogiro(WriterInterface $writer): void
    {
        $this->getState()->export($this, $writer);
    }

    /**
     * Check if attribute is set
     */
    public function hasAttribute(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    /**
     * Set an attribute
     */
    public function setAttribute(string $key, string $value): void
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get attribute
     */
    public function getAttribute(string $key): string
    {
        if (!$this->hasAttribute($key)) {
            throw new UnknownIdentifierException("Unknown attribute $key");
        }

        return $this->attributes[$key];
    }

    /**
     * Get all loaded attributes
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
