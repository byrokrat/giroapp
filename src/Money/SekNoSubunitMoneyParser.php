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
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Money;

use Money\Money;
use Money\MoneyParser;

final class SekNoSubunitMoneyParser implements MoneyParser
{
    public function parse($money, $forceCurrency = null)
    {
        if (!is_string($money)) {
            throw new \InvalidArgumentException('Money must be a string');
        }

        $negation = '';

        if (strlen($money) && $money[0] == '-') {
            $negation = '-';
            $money = substr($money, 1);
        }

        $money = ltrim($money, '0');

        if (empty($money)) {
            return Money::SEK('0');
        }

        if (preg_match('/^([0-9]+)\.00$/', $money, $matches)) {
            return Money::SEK($negation . $matches[1]);
        }

        if (!ctype_digit($money)) {
            throw new \InvalidArgumentException('Money must consist of only numbers');
        }

        return Money::SEK($negation . $money . '00');
    }
}
