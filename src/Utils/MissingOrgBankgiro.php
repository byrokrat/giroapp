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
use byrokrat\banking\AccountNumber;
use byrokrat\banking\Formatter\FormatterInterface;

class MissingOrgBankgiro implements AccountNumber
{
    private function throwException(): void
    {
        throw new InvalidSettingException('Missing or invalid organization bankgiro account number');
    }

    public function getBankName(): string
    {
        $this->throwException();
    }

    public function getRawNumber(): string
    {
        $this->throwException();
    }

    public function format(FormatterInterface $formatter): string
    {
        $this->throwException();
    }

    public function getNumber(): string
    {
        $this->throwException();
    }

    public function __toString(): string
    {
        $this->throwException();
    }

    public function prettyprint(): string
    {
        $this->throwException();
    }

    public function get16(): string
    {
        $this->throwException();
    }

    public function getClearingNumber(): string
    {
        $this->throwException();
    }

    public function getClearingCheckDigit(): string
    {
        $this->throwException();
    }

    public function getSerialNumber(): string
    {
        $this->throwException();
    }

    public function getCheckDigit(): string
    {
        $this->throwException();
    }

    public function equals(AccountNumber $account, bool $strict = false): bool
    {
        $this->throwException();
    }
}
