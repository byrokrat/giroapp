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

namespace byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Model\Donor;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Operators as y;
use byrokrat\giroapp\Mapper\Arrayizer\DonorArrayizer;
use byrokrat\giroapp\Mapper\Arrayizer\PostalAddressArrayizer;
use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Model\DonorState;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\banking\AccountFactory;
use byrokrat\id\PersonalId;

/**
 * Maps donor objects to database collection
 */
class DonorMapper
{
    /**
     * @var CollectionInterface
     */
    private $collection;

    /**
     * @var DonorArrayizer
     */
    private $donorArrayizer;

    /**
     * @var PostalAddressArrayizer
     */
    private $addressArrayizer;

    public function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
        $this->addressArrayizer = new PostalAddressArrayizer();
        $this->donorArrayizer = new DonorArrayizer($this->addressArrayizer);
        $this->donorBuilder = new DonorBuilder();
        $this->accountFactory = new AccountFactory();
    }

    /**
     * Get a unique donor identified by key
     */
    public function findByKey(string $key): Donor
    {
        return $this->collection->has($key) ? $this->collection->read($key)['value'] : '';
    }

    /**
     * Save donor (insert or update)
     */
    public function save(Donor $donor)
    {
        if ($this->collection->has($donor->getMandateKey())) {
            $this->collection->update(
                y::doc(
                    ['mandateKey',
                    y::equals($donor->getMandateKey())]
                ),
                $this->donorArrayizer->toArray($donor)
            );
        } else {
            $this->collection->insert(
                $this->donorArrayizer->toArray($donor),
                $donor->getMandateKey()
            ) ;
        }
    }

    /**
     * Find all donors in storage
     *
     * @return Donor[] Returns an array of Donor objects
     */
    public function findAll(): array
    {
        $result = $this->collection->find(
            y::doc([
                'mandateKey' => y::regexp('/\A[a-z0-9]{16}\Z/i')
            ])
        );
        return $this->buildDonorArray($result);
    }

    /**
     * Find active donor mandate identified by payer number
     */
    public function findByActivePayerNumber(string $payerNumber): Donor
    {
        throw new \Exception("PENDING IMPLEMENTATION");
    }

    /**
     * Find donor mandates identified by payer number
     *
     * NOTE: This may include older deleted mandates.
     *
     * @return Donor[] Returns an array of Donor objects
     */
    public function findByPayerNumber(string $payerNumber): array
    {
        $result = $this->collection->find(
            y::doc([
                'payerNumber' => y::equals($payerNumber)
            ])
        );
        return $this->buildDonorArray($result);
    }

    /**
     * Delete donor from storage
     */
    public function delete(Donor $donor)
    {
        $this->collection->delete(
            y::doc([
                'mandateKey' => $donor->getMandateKey()
            ])
        );
    }

    /**
     * take an array of donors read from doc, and return an array of donors
     *
     * @return Donor[] Returns an array of Donor objects
     */
    private function buildDonorArray(array $doc): array
    {
        $donorArray = array();
        foreach ($result as $id => $doc) {
            $donorArray[$id] = $this->buildDonor($doc);
        }
        return $donorArray;
    }

    /**
     * take an array read from doc, and build donor object
     */
    private function buildDonor(string $doc): Donor
    {
        return $this->donorBuilder->buildDonor(
            new DonorState($doc['state']),
            $doc['mandateSource'],
            $doc['payerNumber'],
            $this->accountFactory->createAccount($doc['account']),
            //TODO: check if personal or organization ID
            new PersonalId($doc['donorId']),
            $doc['name'],
            new PostalAddress(
                $doc['address']['postalCode'],
                $doc['address']['postalCity'],
                $doc['address']['address1'],
                $doc['address']['address2'],
                $doc['address']['coAddress']
            ),
            new SEK($doc['donationAmount']),
            $doc['comment'],
            intval($doc['dayOfMonth']),
            intval($doc['minDaysInFuture'])
        );
    }
}
