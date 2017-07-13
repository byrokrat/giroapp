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

namespace byrokrat\giroapp\Mapper\Arrayizer;

use byrokrat\giroapp\Model\PostalAddress;

/**
 * Takes a Address object and transforms it to an array
 */

class PostalAddressArrayizer
{
    /**
     * Databyse object type & version
     */
    const TYPE_VERSION = 'giroapp/postaladdress:0.1';

    /**
     * @Return string[] Returns PostalAddress as string array
     */
    public function toArray(PostalAddress $address) : array
    {
        return [
            'coAddress' => $address->getCoAddress(),
            'address1' => $address->getAddress1(),
            'address2' => $address->getAddress2(),
            'postalCode' => $address->getPostalCode(),
            'postalCity' => $address->getPostalCity(),
            'type' => self::TYPE_VERSION
        ];
    }

    public function fromArray(array $doc) : PostalAddress
    {
        return new PostalAddress(
            $doc['postalCode'],
            $doc['postalCity'],
            $doc['address1'],
            $doc['address2'],
            $doc['coAddress']
        );
    }
}
