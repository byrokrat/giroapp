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

namespace byrokrat\giroapp\Config;

use byrokrat\giroapp\Exception\InvalidConfigException;
use byrokrat\banking\AccountNumber;
use byrokrat\banking\Formatter\FormatterInterface;

class NullOrgBankgiro implements AccountNumber
{
    private const MESSAGE = 'Missing or invalid organization bankgiro account number';

    public function getBankName(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function getRawNumber(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function format(FormatterInterface $formatter): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function getNumber(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function __toString(): string
    {
        return '';
    }

    public function prettyprint(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function get16(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function getClearingNumber(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function getClearingCheckDigit(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function getSerialNumber(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function getCheckDigit(): string
    {
        throw new InvalidConfigException(self::MESSAGE);
    }

    public function equals(AccountNumber $account, bool $strict = false): bool
    {
        throw new InvalidConfigException(self::MESSAGE);
    }
}
