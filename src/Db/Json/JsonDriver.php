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

use byrokrat\giroapp\Db\DriverInterface;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Db\ImportHistoryInterface;
use byrokrat\giroapp\Utils\SystemClock;
use hanneskod\yaysondb\Yaysondb;

final class JsonDriver implements DriverInterface
{
    /** @var Yaysondb */
    private $db;

    /** @var SystemClock */
    private $systemClock;

    public function __construct(Yaysondb $db, SystemClock $systemClock)
    {
        $this->db = $db;
        $this->systemClock = $systemClock;
    }

    public function getDonorRepository(): DonorRepositoryInterface
    {
        return new JsonDonorRepository($this->db->collection('donors'), $this->systemClock);
    }

    public function getImportHistory(): ImportHistoryInterface
    {
        return new JsonImportHistory($this->db->collection('imports'), $this->systemClock);
    }

    public function commit(): void
    {
        $this->db->commit();
    }

    public function rollback(): void
    {
        $this->db->reset();
    }
}
