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
 * Copyright 2016-21 Hannes Forsgård
 */

namespace byrokrat\giroapp\Db;

use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Exception\DonorAlreadyExistsException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\StateInterface;
use Money\Money;

/**
 * Defines the interface for manipulating the donor repository
 *
 * All concrete database layers must contain an implementation of this interface
 */
interface DonorRepositoryInterface extends DonorQueryInterface
{
    /**
     * @throws DonorAlreadyExistsException If mandate key is already in repository
     * @throws DonorAlreadyExistsException If payer number is already in repository
     * @throws DonorAlreadyExistsException If personal id is already in repository
     */
    public function addNewDonor(Donor $newDonor): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function deleteDonor(Donor $donor): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function updateDonorName(Donor $donor, string $newName): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function updateDonorState(Donor $donor, StateInterface $newState): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     * @throws DonorAlreadyExistsException If payer number is already in repository
     */
    public function updateDonorPayerNumber(Donor $donor, string $newPayerNumber): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function updateDonorAmount(Donor $donor, Money $newAmount): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function updateDonorAddress(Donor $donor, PostalAddress $newAddress): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function updateDonorEmail(Donor $donor, string $newEmail): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function updateDonorPhone(Donor $donor, string $newPhone): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function updateDonorComment(Donor $donor, string $newComment): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function setDonorAttribute(Donor $donor, string $key, string $value): void;

    /**
     * @throws DonorDoesNotExistException If donor does not exist in repository
     */
    public function deleteDonorAttribute(Donor $donor, string $key): void;
}
