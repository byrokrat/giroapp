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
 * Copyright 2016-20 Hannes Forsgård
 */

namespace byrokrat\giroapp\Db;

use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\DonorCollection;

/**
 * Defines the interface for querying the donor repository
 */
interface DonorQueryInterface
{
    /**
     * Find all donors is repository
     */
    public function findAll(): DonorCollection;

    /**
     * @return ?Donor Returns null if mandate key does not exist
     */
    public function findByMandateKey(string $mandateKey): ?Donor;

    /**
     * @throws DonorDoesNotExistException If mandate key does not exist
     */
    public function requireByMandateKey(string $mandateKey): Donor;

    /**
     * @return ?Donor Returns null if payer number does not exist
     */
    public function findByPayerNumber(string $payerNumber): ?Donor;

    /**
     * @throws DonorDoesNotExistException If payer number does not exist
     */
    public function requireByPayerNumber(string $payerNumber): Donor;
}
