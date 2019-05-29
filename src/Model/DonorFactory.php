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

namespace byrokrat\giroapp\Model;

use byrokrat\giroapp\State\StateCollection;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\id\IdFactoryInterface;
use byrokrat\amount\Currency\SEK;

class DonorFactory
{
    /** @var StateCollection */
    private $stateCollection;

    /** @var AccountFactoryInterface */
    private $accountFactory;

    /** @var IdFactoryInterface */
    private $idFactory;

    public function __construct(
        StateCollection $stateCollection,
        AccountFactoryInterface $accountFactory,
        IdFactoryInterface $idFactory
    ) {
        $this->stateCollection = $stateCollection;
        $this->accountFactory = $accountFactory;
        $this->idFactory = $idFactory;
    }

    /**
     * @param string[] $address
     * @param string[] $attributes
     */
    public function createDonor(
        string $mandateKey = '',
        string $state = '',
        string $mandateSource = '',
        string $payerNumber = '',
        string $accountNumber = '',
        string $donorId = '',
        string $name = '',
        array $address = [],
        string $email = '',
        string $phone = '',
        string $donationAmount = '0',
        string $comment = '',
        string $created = '',
        string $updated = '',
        array $attributes = []
    ): Donor {
        return new Donor(
            $mandateKey,
            $this->stateCollection->getState($state),
            $mandateSource,
            $payerNumber,
            $this->accountFactory->createAccount($accountNumber),
            $this->idFactory->createId($donorId),
            $name,
            new PostalAddress(...$address),
            $email,
            $phone,
            new SEK($donationAmount),
            $comment,
            new \DateTimeImmutable($created),
            new \DateTimeImmutable($updated),
            $attributes
        );
    }
}
