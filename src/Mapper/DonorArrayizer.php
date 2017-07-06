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

//declare(strict_types = 1);

namespace byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Model\Donor;

/**
 * Takes a Donor donorObject and transforms it to an donorArray
 */

class DonorArrayizer
{
    /**
     * $var Donor
     */
    private $donorObject;

    /**
     * $var array
     */
    private $donorArray;

    public function __construct(Donor $donorObject)
    {
        $this->donorObject = $donorObject;
    }

    public function getArray() : array
    {
        $donorArray = array();

        $donorArray['state'] = $this->donorObject->getState();
        $donorArray['mandateSource'] = $this->donorObject->getMandateSource();
        $donorArray['payerNumber'] = $this->donorObject->getPayerNumber();
        $donorArray['account'] = $this->donorObject->getAccount();
        $donorArray['donorId'] = $this->donorObject->getDonorId();
        $donorArray['comment'] = $this->donorObject->getComment();
        $donorArray['name'] = $this->donorObject->getName();
        $donorArray['email'] = $this->donorObject->getEmail();
        $donorArray['phone'] = $this->donorObject->getPhone();
        $donorArray['donationAmount'] = $this->donorObject->getDonationAmount();
        $donorArray['mandateKey'] = $this->donorObject->getMandateKey();

        $donorAddressArrayizer = new AddressArrayizer($this->donorObject->getAddress());
        $mergedArray = array_merge($donorArray, $donorAddressArrayizer->getArray());

        return $mergedArray;
    }
}

