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

use byrokrat\giroapp\Db\DriverFactoryInterface;
use byrokrat\giroapp\Db\DriverInterface;
use hanneskod\yaysondb\Yaysondb;
use hanneskod\yaysondb\Engine\FlysystemEngine;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

final class JsonDriverFactory implements DriverFactoryInterface
{
    private const DONORS_FILE = 'donors.json';
    private const IMPORTS_FILE = 'imports.json';

    public function getDriverName(): string
    {
        return 'json';
    }

    public function createDriver(string $dsn): DriverInterface
    {
        $filesystem = new Filesystem(new Local($dsn));

        foreach ([self::DONORS_FILE, self::IMPORTS_FILE] as $requiredFile) {
            if (!$filesystem->has($requiredFile)) {
                $filesystem->write($requiredFile, '');
            }
        }

        return new JsonDriver(
            new Yaysondb([
                'donors' => new FlysystemEngine(self::DONORS_FILE, $filesystem),
                'imports' => new FlysystemEngine(self::IMPORTS_FILE, $filesystem),
            ])
        );
    }
}
