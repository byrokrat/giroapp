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

namespace byrokrat\giroapp\Db;

/**
 * Defines the basic driver interface
 *
 * All concrete database layers must contain an implementation of this interface
 */
interface DriverInterface
{
    /**
     * Get the donor repository for this driver
     */
    public function getDonorRepository(DriverEnvironment $environment): DonorRepositoryInterface;

    /**
     * Get the import history repository for this driver
     */
    public function getImportHistory(DriverEnvironment $environment): ImportHistoryInterface;

    /**
     * @return bool True if changes were actually committed, false otherwise
     */
    public function commit(): bool;

    /**
     * @return bool True if changes were actually discarded, false otherwise
     */
    public function rollback(): bool;
}
