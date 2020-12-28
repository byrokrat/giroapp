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

namespace byrokrat\giroapp;

final class Version
{
    private const VERSION_FILE = __DIR__ . '/../VERSION';

    private static string $version;

    public static function getVersion(): string
    {
        if (!isset(self::$version)) {
            self::$version = self::readVersion();
        }

        return self::$version;
    }

    public static function getSemverVersion(): string
    {
        $version = self::getVersion();

        // drop -X-XXXXXXX from version if present
        if (preg_match('/^(.*)\-\d+\-[0-9a-z]+$/', $version, $matches)) {
            return $matches[1];
        }

        return $version;
    }

    private static function readVersion(): string
    {
        if (is_readable(self::VERSION_FILE)) {
            return trim((string)file_get_contents(self::VERSION_FILE));
        }

        return 'dev-master';
    }
}
