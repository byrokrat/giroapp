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
class SettingsMapper
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
     * Lookup setting identified by key
     */
    public function read(string $key): string
    {
        return $this->collection->has($key) ? $this->collection->read($key)['value'] : '';
    }

    /**
     * Write setting key-value pair
     */
    public function write(string $key, string $value)
    {
        $this->collection->insert(['value' => $value], $key);
    }
}
