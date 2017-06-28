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
use byrokrat\amount\Currency;
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
    private $name;

    /**
     * @var string
     */
    private $coAddress;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $postalCity;

    /**
     * TODO:
     * Contact information should be moved to a separate object, ContactPerson.
     * It should be clear in the end application that this contact information,
     * if added, should only be used to contact the donor on autogiro subjects.
     * This to conform with Data protection regulations.
     */

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var \byrokrat\Amount\Currency
     */
    private $donationAmount;

    public function __construct(
        DonorState $state,
        string $mandateSource,
        string $payerNumber,
        \byrokrat\banking\AccountNumber $account,
        \byrokrat\id\Id $id,
        string $name,
        string $comment = "",
        string $coAddress = "",
        string $address1 = "",
        string $address2 = "",
        string $postalCode = "",
        string $postalCity = ""
    ) {
        $this->setState($state);
        $this->mandateSource = $mandateSource;
        $this->payerNumber = $payerNumber;
        $this->account = $account;
        $this->id = $id;
        $this->comment = $comment;
        $this->name = $name;
        $this->coAddress = $coAddress;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->postalCode = $postalCode;
        $this->postalCity = $postalCity;

        $this->email = "";
        $this->phone = "";
        $this->donationAmount = new \byrokrat\amount\Currency\SEK('0');
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

    public function getPayerNumber(): string
    {
        return $this->payerNumber;
    }

    public function setPayerNumber(string $payerNumber)
    {
        $this->payerNumber = $payerNumber;
    }

    /*
     * Don't think $this is needed. Likely a new autogiro mantade will be issued
     * if the account is changed. However, it might be interesting in our
     * system to link mandates for the same person, but different accounts. But
     * that will probably not be done here.
    public function setAccount(\byrokrat\banking\AccountNumber $account)
    {
        $this->account = $account;
    }
     */

    public function getAccount(): \byrokrat\banking\AccountNumber
    {
        return $this->account;
    }

    public function getId(): \byrokrat\id\Id
    {
        return $this->id;
    }

    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCoAddress(string $coAddress)
    {
        $this->coAddress = $coAddress;
    }

    public function getCoAddress(): string
    {
        return $this->coAddress;
    }

    public function setAddress1(string $address1)
    {
        $this->address1 = $address1;
    }

    public function getAddress1(): string
    {
        return $this->address1;
    }

    public function setAddress2(string $address2)
    {
        $this->address2 = $address2;
    }

    public function getAddress2(): string
    {
        return $this->address2;
    }

    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCity(string $postalCity)
    {
        $this->postalCity = $postalCity;
    }

    public function getPostalCity(): string
    {
        return $this->postalCity;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
    }

    public function getDonationAmount(): Currency
    {
        return $this->donationAmount;
    }

    public function setDonationAmount(Currency $donationAmount)
    {
        $this->donationAmount = $donationAmount;
    }

    public function exportToAutogiro(Writer $writer)
    {
        $this->getState()->export($this, $writer);
    }
}
