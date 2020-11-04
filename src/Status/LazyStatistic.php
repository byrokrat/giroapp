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

namespace byrokrat\giroapp\Status;

final class LazyStatistic implements StatisticInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var callable */
    private $valueFactory;

    public function __construct(string $name, string $description, callable $valueFactory)
    {
        $this->name = $name;
        $this->description = $description;
        $this->valueFactory = $valueFactory;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getValue(): int
    {
        $value = ($this->valueFactory)();

        if (!is_int($value)) {
            throw new \LogicException("Invalid value factory return type. Must be an integer.");
        }

        return $value;
    }
}
