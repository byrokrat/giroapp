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

/**
 * Mapps key-value pairs to a db collection
 */
class FilechecksumMapper
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
     * Check for presence of a record by hash
     */
    public function has(string $key): bool
    {
        return $this->collection->has($key);
    }

    /**
     * Lookup record identified by hash
     *
     * @return array of arrays
     */
    public function findByKey(string $key): array
    {
        return $this->collection->has($key) ? $this->collection->read($key) : '';
    }

    /**
     * Save file hash record
     */
    public function save(string $key, array $values)
    {
        $this->collection->insert($values, $key);
    }
}
