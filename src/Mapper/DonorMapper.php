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

namespace byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Exception\DonorAlreadyExistsException;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\DonorCollection;
use byrokrat\giroapp\Utils\SystemClock;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Operators as y;

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
     * @var DonorSchema
     */
    private $donorSchema;

    /**
     * @var SystemClock
     */
    private $systemClock;

    public function __construct(CollectionInterface $collection, DonorSchema $donorSchema, SystemClock $systemClock)
    {
        $this->collection = $collection;
        $this->donorSchema = $donorSchema;
        $this->systemClock = $systemClock;
    }

    /**
     * Check if a donor with specified key exists in database
     */
    public function hasKey(string $key): bool
    {
        return $this->collection->has($key);
    }

    /**
     * Get a unique donor identified by key
     */
    public function findByKey(string $key): Donor
    {
        if ($this->collection->has($key)) {
            return $this->donorSchema->fromArray($this->collection->read($key));
        }

        throw new DonorDoesNotExistException("unknown donor key: $key");
    }

    /**
     * Get Donor objects in storage
     */
    public function findAll(): DonorCollection
    {
        return new DonorCollection(function () {
            foreach ($this->collection as $doc) {
                yield $this->donorSchema->fromArray($doc);
            }
        });
    }

    /**
     * Find active donor mandate identified by payer number.
     */
    public function findByActivePayerNumber(string $payerNumber): Donor
    {
        $doc = $this->collection->findOne(
            y::doc([
                'payer_number' => y::equals($payerNumber),
                'state' => y::not(y::equals(States::INACTIVE))
            ])
        );

        if (empty($doc)) {
            throw new DonorDoesNotExistException("Unknown payer number: $payerNumber");
        }

        return $this->donorSchema->fromArray($doc);
    }

    /**
     * Get all donor objects identified by payer number
     *
     * NOTE: This may include older deleted mandates.
     */
    public function findByPayerNumber(string $payerNumber): DonorCollection
    {
        return new DonorCollection(function () use ($payerNumber) {
            foreach ($this->collection->find(y::doc(['payer_number' => y::equals($payerNumber)])) as $doc) {
                yield $this->donorSchema->fromArray($doc);
            }
        });
    }

    /**
     * Delete donor from storage
     */
    public function delete(Donor $donor): void
    {
        $this->collection->delete(
            y::doc(['mandate_key' => y::equals($donor->getMandateKey())])
        );
    }

    /**
     * Save a new donor
     */
    public function create(Donor $donor): void
    {
        if ($this->hasKey($donor->getMandateKey())) {
            throw new DonorAlreadyExistsException(
                sprintf(
                    'A donor with ID %s and bank account %s already exists',
                    $donor->getDonorId()->format('S-sk'),
                    $donor->getAccount()->getNumber()
                )
            );
        }

        $this->save($donor);
    }

    /**
     * Update an existing donor
     */
    public function update(Donor $donor): void
    {
        if (!$this->hasKey($donor->getMandateKey())) {
            throw new DonorDoesNotExistException(
                sprintf(
                    'Unable to update donor %s, does not exist in database',
                    $donor->getMandateKey()
                )
            );
        }

        $donor->setUpdated($this->systemClock->getNow());
        $this->save($donor);
    }

    /**
     * Save donor (insert or update)
     */
    private function save(Donor $donor): void
    {
        $expr = y::doc([
            'payer_number' => y::equals($donor->getPayerNumber()),
            'mandate_key' => y::not(y::equals($donor->getMandateKey())),
            'state' => y::not(y::equals(States::INACTIVE))
        ]);

        if ($this->collection->findOne($expr)) {
            throw new DonorAlreadyExistsException(
                sprintf(
                    "Unable to save donor %s, a mandate already exists. Try '%s' for more information.",
                    $donor->getMandateKey(),
                    "giroapp show {$donor->getPayerNumber()} --format=list"
                )
            );
        }

        $this->collection->insert(
            $this->donorSchema->toArray($donor),
            $donor->getMandateKey()
        );
    }
}
