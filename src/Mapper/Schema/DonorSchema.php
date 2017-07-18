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

namespace byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Mapper\Schema\PostalAddressSchema;
use byrokrat\giroapp\Model\DonorState\DonorStateFactory;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use byrokrat\amount\Currency\SEK;
use hanneskod\yaysondb\Expression\ExpressionInterface;
use hanneskod\yaysondb\Operators as y;

/**
 * Takes a Donor object and transforms it to an array
 */
class DonorSchema
{
    const TYPE_VERSION = 'giroapp/donor:0.1';

    /**
     * @var PostalAddressSchema
     */
    private $addressSchema;

    /**
     * @var DonorStateFactory
     */
    private $donorStateFactory;

    /**
     * @var AccountFactory
     */
    private $accountFactory;

    /**
     * @var IdFactory
     */
    private $idFactory;

    public function __construct(
        PostalAddressSchema $postalAddressSchema,
        DonorStateFactory $donorStateFactory,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->addressSchema = $postalAddressSchema;
        $this->donorStateFactory = $donorStateFactory;
        $this->accountFactory = $accountFactory;
        $this->idFactory = $idFactory;
    }

    public function toArray(Donor $donor): array
    {
        return [
            'type' => self::TYPE_VERSION,
            'mandateKey' => $donor->getMandateKey(),
            'state' => $donor->getState()->getId(),
            'mandateSource' => $donor->getMandateSource(),
            'payerNumber' => $donor->getPayerNumber(),
            'account' => $donor->getAccount()->getNumber(),
            'donorId' => $donor->getDonorId()->format('S-sk'),
            'name' => $donor->getName(),
            'address' => $this->addressSchema->toArray($donor->getAddress()),
            'email' => $donor->getEmail(),
            'phone' => $donor->getPhone(),
            'donationAmount' => $donor->getDonationAmount()->getAmount(),
            'comment' => $donor->getComment()
        ];
    }

    public function fromArray(array $doc): Donor
    {
        return new Donor(
            $doc['mandateKey'],
            $this->donorStateFactory->createDonorState($doc['state']),
            $doc['mandateSource'],
            $doc['payerNumber'],
            $this->accountFactory->createAccount($doc['account']),
            $this->idFactory->create($doc['donorId']),
            $doc['name'],
            $this->addressSchema->fromArray($doc['address']),
            $doc['email'],
            $doc['phone'],
            new SEK($doc['donationAmount']),
            $doc['comment']
        );
    }

    public function getPayerNumberSearchExpression(string $payerNumber): ExpressionInterface
    {
        return y::doc(['payerNumber' => y::equals($payerNumber)]);
    }

    public function getMandateKeySearchExpression(string $mandateKey): ExpressionInterface
    {
        return y::doc(['mandateKey' => y::equals($mandateKey)]);
    }
}
