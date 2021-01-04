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

declare(strict_types=1);

namespace byrokrat\giroapp\Config;

use byrokrat\giroapp\Exception\InvalidConfigException;

class ConfigManager
{
    /**
     * @var array<string, string>
     */
    private $configs = [];

    public function __construct(RepositoryInterface ...$repos)
    {
        foreach ($repos as $repo) {
            $this->loadRepository($repo);
        }
    }

    public function loadRepository(RepositoryInterface $configs): void
    {
        $this->configs = array_merge($this->configs, $configs->getConfigs());
    }

    public function getConfig(string $name): ConfigInterface
    {
        return new LazyConfig(function () use ($name) {
            if (!isset($this->configs[$name])) {
                throw new InvalidConfigException("Configuration for '$name' missing.");
            }

            $value = $this->configs[$name];

            if (!is_string($value)) {
                throw new InvalidConfigException("Configuration '$name' must be string, found: " . gettype($value));
            }

            $value = preg_replace_callback(
                '/%([^%]+)%/',
                function ($matches) {
                    return $this->getConfigValue($matches[1]);
                },
                $value
            );

            return $value;
        });
    }

    public function getConfigValue(string $name): string
    {
        return $this->getConfig($name)->getValue();
    }
}
