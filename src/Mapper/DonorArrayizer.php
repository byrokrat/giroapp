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

use byrokrat\giroapp\Model\Donor;

/**
 * Takes a Donor object and transforms it to an array
 */

class DonorArrayizer
{
    public static function getArray(Donor $donor) : array
    {
        $donorArray = array();

        $donorArray['state'] = $donor->getState();
        $donorArray['mandateSource'] = $donor->getMandateSource();
        $donorArray['payerNumber'] = $donor->getPayerNumber();
        $donorArray['account'] = $donor->getAccount();
        $donorArray['donorId'] = $donor->getDonorId();
        $donorArray['comment'] = $donor->getComment();
        $donorArray['name'] = $donor->getName();
        $donorArray['email'] = $donor->getEmail();
        $donorArray['phone'] = $donor->getPhone();
        $donorArray['donationAmount'] = $donor->getDonationAmount();
        $donorArray['mandateKey'] = $donor->getMandateKey();

        $mergedArray = array_merge($donorArray, AddressArrayizer::getArray($donor->getAddress));

        return $mergedArray;
    }
}
