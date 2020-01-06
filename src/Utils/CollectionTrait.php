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

declare(strict_types = 1);

namespace byrokrat\giroapp\Utils;

use byrokrat\giroapp\Exception\UnknownIdentifierException;

trait CollectionTrait
{
    /** @var array<string, mixed> */
    private $items = [];

    abstract protected function describeItem(): string;

    /**
     * @param mixed $item
     */
    protected function addItem(string $key, $item): void
    {
        $this->items[$key] = $item;
    }

    protected function hasItem(string $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * @return mixed
     */
    protected function getItem(string $key)
    {
        if (!$this->hasItem($key)) {
            throw new UnknownIdentifierException(sprintf(
                "%s '%s' does not exist",
                $this->describeItem(),
                $key
            ));
        }

        return $this->items[$key];
    }

    /**
     * @return string[]
     */
    public function getItemKeys(): array
    {
        return array_filter(array_keys($this->items));
    }

    /**
     * @return mixed[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
