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

namespace byrokrat\giroapp\Mapper\Arrayizer;

use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Mapper\Arrayizer\PostalAddressArrayizer;
use byrokrat\giroapp\Model\DonorState\DonorStateFactory;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use byrokrat\amount\Currency\SEK;

/**
 * Takes a Donor object and transforms it to an array
 */
class DonorArrayizer
{
    const TYPE_VERSION = 'giroapp/donor:0.1';

    /**
     * @var PostalAddressArrayizer
     */
    private $addressArrayizer;

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
        PostalAddressArrayizer $postalAddressArrayizer,
        DonorStateFactory $donorStateFactory,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->addressArrayizer = $postalAddressArrayizer;
        $this->donorStateFactory = $donorStateFactory;
        $this->accountFactory = $accountFactory;
        $this->idFactory = $idFactory;
    }

    public function toArray(Donor $donor): array
    {
        return [
            'mandateKey' => $donor->getMandateKey(),
            'state' => $donor->getState()->getId(),
            'mandateSource' => $donor->getMandateSource(),
            'payerNumber' => $donor->getPayerNumber(),
            'account' => $donor->getAccount()->getNumber(),
            'donorId' => $donor->getDonorId()->format('S-sk'),
            'name' => $donor->getName(),
            'address' => $this->addressArrayizer->toArray($donor->getAddress()),
            'email' => $donor->getEmail(),
            'phone' => $donor->getPhone(),
            'donationAmount' => $donor->getDonationAmount()->getAmount(),
            'comment' => $donor->getComment(),
            'type' => self::TYPE_VERSION
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
            $this->idFactory->create($doc['id']),
            $doc['name'],
            $this->addressArrayizer->fromArray($doc['address']),
            new SEK($doc['donationAmount']),
            $doc['comment']
        );
    }
}
