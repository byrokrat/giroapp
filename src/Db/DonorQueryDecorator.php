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

namespace byrokrat\giroapp\Db;

use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\DonorCollection;

/**
 * Used to extract a donor query from a donor repository implementation
 */
class DonorQueryDecorator implements DonorQueryInterface
{
    /**
     * @var DonorQueryInterface
     */
    private $decorated;

    public function __construct(DonorQueryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function findAll(): DonorCollection
    {
        return $this->decorated->findAll();
    }

    public function findByMandateKey(string $mandateKey): ?Donor
    {
        return $this->decorated->findByMandateKey($mandateKey);
    }

    public function requireByMandateKey(string $mandateKey): Donor
    {
        return $this->decorated->requireByMandateKey($mandateKey);
    }

    public function findByPayerNumber(string $payerNumber): ?Donor
    {
        return $this->decorated->findByPayerNumber($payerNumber);
    }

    public function requireByPayerNumber(string $payerNumber): Donor
    {
        return $this->decorated->requireByPayerNumber($payerNumber);
    }
}
