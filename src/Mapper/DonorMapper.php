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

use byrokrat\giroapp\States;
use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Model\Donor;
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

    public function __construct(CollectionInterface $collection, DonorSchema $donorSchema)
    {
        $this->collection = $collection;
        $this->donorSchema = $donorSchema;
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

        throw new \RuntimeException("unknown donor key: $key");
    }

    /**
     * Find all donors in storage
     *
     * @return Donor[] An iterable containing Donor objects
     */
    public function findAll(): iterable
    {
        foreach ($this->collection as $doc) {
            yield $this->donorSchema->fromArray($doc);
        }
    }

    /**
     * Find active donor mandate identified by payer number.
     *
     * @throws RuntimeException if donor is not found
     */
    public function findByActivePayerNumber(string $payerNumber): Donor
    {
        $doc = $this->collection->findOne(
            y::doc([
                'payer_number' => y::equals($payerNumber),
                'state' => y::not(y::equals(States::INACTIVE))
            ])
        );

        if (!$doc) {
            throw new \RuntimeException("Unknown payer number: $payerNumber");
        }

        return $this->donorSchema->fromArray($doc);
    }

    /**
     * Find donor mandates identified by payer number
     *
     * NOTE: This may include older deleted mandates.
     *
     * @return Donor[] An iterable containing Donor objects
     */
    public function findByPayerNumber(string $payerNumber): iterable
    {
        foreach ($this->collection->find(y::doc(['payer_number' => y::equals($payerNumber)])) as $doc) {
            yield $this->donorSchema->fromArray($doc);
        }
    }

    /**
     * Save donor (insert or update)
     */
    public function save(Donor $donor): void
    {
        $expr = y::doc([
            'payer_number' => y::equals($donor->getPayerNumber()),
            'mandate_key' => y::not(y::equals($donor->getMandateKey())),
            'state' => y::not(y::equals(States::INACTIVE))
        ]);

        if ($this->collection->findOne($expr)) {
            throw new \RuntimeException(
                sprintf(
                    'Unable to save donor %s, a mandate for payer number %s already exists',
                    $donor->getMandateKey(),
                    $donor->getPayerNumber()
                )
            );
        }

        $this->collection->insert(
            $this->donorSchema->toArray($donor),
            $donor->getMandateKey()
        );
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
}
