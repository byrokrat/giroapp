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

namespace byrokrat\giroapp\Mapper\Arrayizer\PostalAddressArrayizer;

use byrokrat\giroapp\Model\Donor;

/**
 * Takes a Donor object and transforms it to an array
 */
class DonorArrayizer
{
    /**
     * @var PostalAddressArrayizer
     */
    private $addressArrayizer;

    const TYPE_VERSION = 'giroapp/donor:0.1';

    public function __construct(
        PostalAddressArrayizer $postalAddressArrayizer = null
    ) {
        $this->addressArrayizer = $postalAddressArrayizer ?: new PostalAddressArrayizer();
    }

    public function toArray(Donor $donor) : array
    {
        return [
            'state' => $this->donor->getState()->getId(),
            'mandateSource' => $this->donor->getMandateSource(),
            'payerNumber' => $this->donor->getPayerNumber(),
            'account' => $this->donor->getAccount()->get16(),
            'donorId' => $this->donor->getDonorId()->format('S-sk'),
            'comment' => $this->donor->getComment(),
            'name' => $this->donor->getName(),
            'address' => $this->addressArrayizer->toArray($donor->address),
            'email' => $this->donor->getEmail(),
            'phone' => $this->donor->getPhone(),
            'donationAmount' => $this->donor->getDonationAmount()->getAmount(),
            'mandateKey' => $this->donor->getMandateKey(),
            'type' => self::TYPE_VERSION
        ];
    }
}
