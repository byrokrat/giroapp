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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Utils;

use byrokrat\giroapp\Exception\InvalidSettingException;
use byrokrat\id\IdInterface;

class MissingOrgId implements IdInterface
{
    private function throwException(): void
    {
        throw new InvalidSettingException('Missing or invalid organization id number');
    }

    public function getId(): string
    {
        $this->throwException();
    }

    public function __tostring(): string
    {
        $this->throwException();
    }

    public function format(string $format): string
    {
        $this->throwException();
    }

    public function getSerialPreDelimiter(): string
    {
        $this->throwException();
    }

    public function getSerialPostDelimiter(): string
    {
        $this->throwException();
    }

    public function getDelimiter(): string
    {
        $this->throwException();
    }

    public function getCheckDigit(): string
    {
        $this->throwException();
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        $this->throwException();
    }

    public function getAge(\DateTimeInterface $atDate = null): int
    {
        $this->throwException();
    }

    public function getCentury(): string
    {
        $this->throwException();
    }

    public function getSex(): string
    {
        $this->throwException();
    }

    public function isMale(): bool
    {
        $this->throwException();
    }

    public function isFemale(): bool
    {
        $this->throwException();
    }

    public function isSexOther(): bool
    {
        $this->throwException();
    }

    public function isSexUndefined(): bool
    {
        $this->throwException();
    }

    public function getBirthCounty(): string
    {
        $this->throwException();
    }

    public function getLegalForm(): string
    {
        $this->throwException();
    }

    public function isLegalFormUndefined(): bool
    {
        $this->throwException();
    }

    public function isStateOrParish(): bool
    {
        $this->throwException();
    }

    public function isIncorporated(): bool
    {
        $this->throwException();
    }

    public function isPartnership(): bool
    {
        $this->throwException();
    }

    public function isAssociation(): bool
    {
        $this->throwException();
    }

    public function isNonProfit(): bool
    {
        $this->throwException();
    }

    public function isTradingCompany(): bool
    {
        $this->throwException();
    }
}
