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
use byrokrat\giroapp\State\StateFactory;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use byrokrat\amount\Currency\SEK;
use hanneskod\yaysondb\Expression\ExpressionInterface;
use hanneskod\yaysondb\Operators as y;

/**
 * Maps Donor objects to arrays
 */
class DonorSchema
{
    /**
     * Schema type identifier
     */
    const TYPE = 'giroapp/donor:alpha2';

    /**
     * @var PostalAddressSchema
     */
    private $addressSchema;

    /**
     * @var StateFactory
     */
    private $stateFactory;

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
        StateFactory $stateFactory,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->addressSchema = $postalAddressSchema;
        $this->stateFactory = $stateFactory;
        $this->accountFactory = $accountFactory;
        $this->idFactory = $idFactory;
    }

    public function toArray(Donor $donor): array
    {
        return [
            'type' => self::TYPE,
            'mandate_key' => $donor->getMandateKey(),
            'state' => $donor->getState()->getId(),
            'mandate_source' => $donor->getMandateSource(),
            'payer_number' => $donor->getPayerNumber(),
            'account' => $donor->getAccount()->getNumber(),
            'donor_id' => $donor->getDonorId()->format('S-sk'),
            'name' => $donor->getName(),
            'address' => $this->addressSchema->toArray($donor->getAddress()),
            'email' => $donor->getEmail(),
            'phone' => $donor->getPhone(),
            'donation_amount' => $donor->getDonationAmount()->getAmount(),
            'comment' => $donor->getComment(),
            'attributes' => $donor->getAttributes()
        ];
    }

    public function fromArray(array $doc): Donor
    {
        return new Donor(
            $doc['mandate_key'],
            $this->stateFactory->createState($doc['state']),
            $doc['mandate_source'],
            $doc['payer_number'],
            $this->accountFactory->createAccount($doc['account']),
            $this->idFactory->create($doc['donor_id']),
            $doc['name'],
            $this->addressSchema->fromArray($doc['address']),
            $doc['email'],
            $doc['phone'],
            new SEK($doc['donation_amount']),
            $doc['comment'],
            $doc['attributes'] ?? []
        );
    }

    public function getPayerNumberSearchExpression(string $payerNumber): ExpressionInterface
    {
        return y::doc(['payer_number' => y::equals($payerNumber)]);
    }

    public function getMandateKeySearchExpression(string $mandateKey): ExpressionInterface
    {
        return y::doc(['mandate_key' => y::equals($mandateKey)]);
    }
}
