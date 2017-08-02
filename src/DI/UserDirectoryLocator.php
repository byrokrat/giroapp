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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\DI;

/**
 * Rules for locating the current user config directory
 */
class UserDirectoryLocator
{
    const DEFAULT_DIR_NAME = '.giroapp';

    /**
     * @var callable
     */
    private $fallback;

    /**
     * Optionally supply a fallback used when no other strategy for finding home works
     */
    public function __construct(callable $fallback = null)
    {
        $this->fallback = $fallback ?: function () {
            if (function_exists('posix_getuid')) {
                return $this->expand(posix_getpwuid(posix_getuid())['dir']);
            }

            return '';
        };
    }

    /**
     * Locate home from option, environment var, environment home, a copy of $_ENV or a copy of $_SERVER
     */
    public function locateUserDirectory(
        string $option,
        string $envPath,
        string $envHome,
        array $env,
        array $server
    ): string {
        $dir = $option
            ?: $envPath
            ?: $this->expand($envHome)
            ?: $this->parseHome($env)
            ?: $this->parseHome($server)
            ?: ($this->fallback)();

        if (!$dir) {
            throw new \RuntimeException('Unable to locate user directory');
        }

        return $dir;
    }

    /**
     * Parse home from an $_ENV or $_SERVER style array
     */
    private function parseHome(array $values): string
    {
        if (isset($values['HOME'])) {
            return $this->expand($values['HOME']);
        }

        if (isset($values['HOMEDRIVE']) && isset($values['HOMEPATH'])) {
            return $this->expand($values['HOMEDRIVE'] . $values['HOMEPATH']);
        }

        return '';
    }

    /**
     * Append default directory name to $dir
     */
    private function expand(string $dir): string
    {
        return $dir ? $dir . DIRECTORY_SEPARATOR . self::DEFAULT_DIR_NAME : '';
    }
}
