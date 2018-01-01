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

use byrokrat\giroapp\Model\PostalAddress;

/**
 * Maps PostalAddress objects to arrays
 */
class PostalAddressSchema
{
    /**
     * Schema type identifier
     */
    const TYPE = 'giroapp/postaladdress:alpha2';

    /**
     * @return string[] Returns PostalAddress as string array
     */
    public function toArray(PostalAddress $address) : array
    {
        return [
            'type' => self::TYPE,
            'line1' => $address->getLine1(),
            'line2' => $address->getLine2(),
            'line3' => $address->getLine3(),
            'postal_code' => $address->getPostalCode(),
            'postal_city' => $address->getPostalCity()
        ];
    }

    public function fromArray(array $doc) : PostalAddress
    {
        return new PostalAddress(
            $doc['line1'],
            $doc['line2'],
            $doc['line3'],
            $doc['postal_code'],
            $doc['postal_city']
        );
    }
}
