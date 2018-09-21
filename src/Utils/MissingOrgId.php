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
    private const MESSAGE = 'Missing or invalid organization id number';

    public function getId(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function __tostring(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function format(string $format): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getSerialPreDelimiter(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getSerialPostDelimiter(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getDelimiter(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getCheckDigit(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getAge(\DateTimeInterface $atDate = null): int
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getCentury(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getSex(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isMale(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isFemale(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isSexOther(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isSexUndefined(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getBirthCounty(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function getLegalForm(): string
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isLegalFormUndefined(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isStateOrParish(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isIncorporated(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isPartnership(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isAssociation(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isNonProfit(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }

    public function isTradingCompany(): bool
    {
        throw new InvalidSettingException(self::MESSAGE);
    }
}
