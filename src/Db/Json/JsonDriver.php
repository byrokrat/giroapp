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

declare(strict_types=1);

namespace byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\DriverInterface;
use byrokrat\giroapp\Db\DriverEnvironment;
use byrokrat\giroapp\Db\DonorEventStoreInterface;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Db\ImportHistoryInterface;
use hanneskod\yaysondb\Yaysondb;

final class JsonDriver implements DriverInterface
{
    /** @var Yaysondb */
    private $db;

    public function __construct(Yaysondb $db)
    {
        $this->db = $db;
    }

    public function getDonorEventStore(DriverEnvironment $environment): DonorEventStoreInterface
    {
        return new JsonDonorEventStore($this->db->collection('donor_events'));
    }

    public function getDonorRepository(DriverEnvironment $environment): DonorRepositoryInterface
    {
        return new JsonDonorRepository(
            $this->db->collection('donors'),
            $environment->getDonorFactory(),
            $environment->getClock(),
            $environment->getMoneyFormatter()
        );
    }

    public function getImportHistory(DriverEnvironment $environment): ImportHistoryInterface
    {
        return new JsonImportHistory(
            $this->db->collection('imports'),
            $environment->getClock()
        );
    }

    public function commit(): bool
    {
        if ($this->db->inTransaction()) {
            $this->db->commit();
            return true;
        }

        return false;
    }

    public function rollback(): bool
    {
        if ($this->db->inTransaction()) {
            $this->db->reset();
            return true;
        }

        return false;
    }
}
