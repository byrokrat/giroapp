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

use byrokrat\giroapp\Mapper\Schema\FileChecksumSchema;
use byrokrat\giroapp\Model\FileChecksum;
use hanneskod\yaysondb\CollectionInterface;

/**
 * Maps file checksum objects to database collection
 */
class FileChecksumMapper
{
    /**
     * @var CollectionInterface
     */
    private $collection;

    /**
     * @var FileChecksumSchema
     */
    private $checksumSchema;

    public function __construct(CollectionInterface $collection, FileChecksumSchema $checksumSchema)
    {
        $this->collection = $collection;
        $this->checksumSchema = $checksumSchema;
    }

    /**
     * Check if a checksum with specified key exists in database
     */
    public function hasKey(string $key): bool
    {
        return $this->collection->has($key);
    }

    /**
     * Get a unique checksum identified by key
     */
    public function findByKey(string $key): FileChecksum
    {
        if ($this->hasKey($key)) {
            return $this->checksumSchema->fromArray($this->collection->read($key));
        }

        throw new \RuntimeException("Unknown checksum $key");
    }

    /**
     * Insert a checksum object to database
     *
     * @throws \RuntimeException if checksum already exists
     */
    public function insert(FileChecksum $fileChecksum): void
    {
        if ($this->hasKey($fileChecksum->getChecksum())) {
            throw new \RuntimeException('Unable to insert, checksum already exists');
        }

        $this->collection->insert(
            $this->checksumSchema->toArray($fileChecksum),
            $fileChecksum->getChecksum()
        );
    }
}
