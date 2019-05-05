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

namespace byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Exception\DonorExistsException;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\DonorCollection;
use byrokrat\giroapp\Model\NewDonor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Utils\SystemClock;
use hanneskod\yaysondb\CollectionInterface;

final class JsonDonorRepository implements DonorRepositoryInterface
{
    /**
     * @var CollectionInterface
     */
    private $collection;

    /**
     * @var SystemClock
     */
    private $systemClock;

    public function __construct(CollectionInterface $collection, SystemClock $systemClock)
    {
        $this->collection = $collection;
        $this->systemClock = $systemClock;
    }

    public function findAll(): DonorCollection
    {
    }

    public function findByMandateKey(string $mandateKey): ?Donor
    {
    }

    /**
     * @throws DonorDoesNotExistException If mandate key does not exist
     */
    public function requireByMandateKey(string $mandateKey): Donor
    {
    }

    /**
     * Implies working mandates, purgeable donors will not be found.
     *
     * @return ?Donor Returns null if payer number does not exist
     */
    public function findByPayerNumber(string $payerNumber): ?Donor
    {
    }

    /**
    * Implies working mandates, purgeable donors will not be found.
    *
     * @throws DonorDoesNotExistException If payer number does not exist
     */
    public function requireByPayerNumber(string $payerNumber): Donor
    {
    }

    /**
     * @return string The mandate key of created donor
     * @throws DonorExistsException If a conflicting donor already exists
     */
    public function insertDonor(NewDonor $donor): string
    {
    }

    /**
     * @throws DonorDoesNotExistException If donor does not exist
     */
    public function deleteDonor(Donor $donor): void
    {
    }

    /**
     * @throws DonorDoesNotExistException If donor does not exist
     */
    public function updateDonorAddress(Donor $donor, PostalAddress $newAddress): void
    {
    }
}
