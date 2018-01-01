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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Model\FileChecksum;

/**
 * Maps FileChecksum objects to arrays
 */
class FileChecksumSchema
{
    /**
     * Schema type identifier
     */
    const TYPE = 'giroapp/filechecksum:alpha2';

    /**
     * @return string[] Returns FileChecksum as string array
     */
    public function toArray(FileChecksum $checksum) : array
    {
        return [
            'type' => self::TYPE,
            'filename' => $checksum->getFilename(),
            'checksum' => $checksum->getChecksum(),
            'datetime' => $checksum->getDatetime()->format(\DateTime::W3C)
        ];
    }

    public function fromArray(array $doc) : FileChecksum
    {
        return new FileChecksum(
            $doc['filename'],
            $doc['checksum'],
            new \DateTimeImmutable($doc['datetime'])
        );
    }
}
