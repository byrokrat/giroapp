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

/**
 * Mapps donor objects to database collection
 */
class DonorMapper
{
    /**
     * @var CollectionInterface
     */
    private $collection;

    public function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Find all donors in storage
     *
     * @return Donor[] Returns an array of Donor objects
     */
    public function findAll(): array
    {
        throw new \Exception("PENDING IMPLEMENTATION");
    }

    /**
     * Get a unique donor identified by key
     */
    public function findByKey(string $key): Donor
    {
        throw new \Exception("PENDING IMPLEMENTATION");
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
        throw new \Exception("PENDING IMPLEMENTATION");
    }

    /**
     * Save donor to storage
     */
    public function save(Donor $donor)
    {
        throw new \Exception("PENDING IMPLEMENTATION");
    }

    /**
     * Delete donor from storage
     */
    public function delete(Donor $donor)
    {
        throw new \Exception("PENDING IMPLEMENTATION");
    }
}
