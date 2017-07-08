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

use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Operators as y;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Mapper\Arrayizer;

/**
 * Maps donor objects to database collection
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
     * Lookup donor identified by key
     */
    public function read(string $key): string
    {
        return $this->collection->has($key) ? $this->collection->read($key)['value'] : '';
    }

    /**
     * Write donor key-value array
     */
    public function write(Donor $donor)
    {
        $addressArrayizer = new AddressArrayizer($donor->address);
        $donorArrayizer = new DonorArrayizer($donor);
        $this->collection->insert($donorArrayizer->getArray(), $donor->getMandateKey());
    }

    /**
     * Commit changes to storage
     */
    public function commit()
    {
        if ($this->collection->inTransaction()) {
            $this->collection->commit();
        }
    }
}
