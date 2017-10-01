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

namespace byrokrat\giroapp\Model;

/**
 * Models a swedish postal address
 */
class PostalAddress
{
    /**
     * @var string
     */
    private $line1;

    /**
     * @var string
     */
    private $line2;

    /**
     * @var string
     */
    private $line3;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $postalCity;

    public function __construct(
        string $line1,
        string $line2,
        string $line3,
        string $postalCode,
        string $postalCity
    ) {
        $this->line1 = $line1;
        $this->line2 = $line2;
        $this->line3 = $line3;
        $this->postalCode = $postalCode;
        $this->postalCity = $postalCity;
    }

    public function getLine1(): string
    {
        return $this->line1;
    }

    public function getLine2(): string
    {
        return $this->line2;
    }

    public function getLine3(): string
    {
        return $this->line3;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getPostalCity(): string
    {
        return $this->postalCity;
    }
}
