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

use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Model\Donor;
use hanneskod\yaysondb\CollectionInterface;

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
     * @return boolean
     */
    public function hasKey(string $key): boolean
    {
        if ($this->collection->has($key)) {
            return true;
        }

        return false;
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
     * Save donor (insert or update)
     */
    public function save(Donor $donor)
    {
        $this->collection->insert(
            $this->donorSchema->toArray($donor),
            $donor->getMandateKey()
        );
    }

    /**
     * Find all donors in storage
     *
     * @return Donor[] Returns an array of Donor objects
     */
    public function findAll(): array
    {
        $donors = [];

        foreach ($this->collection as $doc) {
            $donors[] = $this->donorSchema->fromArray($doc);
        }

        return $donors;
    }

    /**
     * Find active donor mandate identified by payer number
     */
    public function findByActivePayerNumber(string $payerNumber): Donor
    {
        return $this->donorSchema->fromArray(
            $this->collection->findOne(
                $this->donorSchema->getPayerNumberSearchExpression($payerNumber)
            )
        );
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
        $donors = [];

        foreach ($this->collection->find($this->donorSchema->getPayerNumberSearchExpression($payerNumber)) as $doc) {
            $donors[] = $this->donorSchema->fromArray($doc);
        }

        return $donors;
    }

    /**
     * Delete donor from storage
     */
    public function delete(Donor $donor)
    {
        $this->collection->delete(
            $this->donorSchema->getMandateKeySearchExpression($donor->getMandateKey())
        );
    }
}
