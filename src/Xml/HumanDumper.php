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

namespace byrokrat\giroapp\Xml;

use byrokrat\giroapp\Console\ConsoleInterface;
use Money\MoneyFormatter;

final class HumanDumper implements XmlMandateDumperInterface
{
    private const COLORING_TAG = 'comment';

    /** @var MoneyFormatter */
    private $moneyFormatter;

    public function __construct(MoneyFormatter $moneyFormatter)
    {
        $this->moneyFormatter = $moneyFormatter;
    }

    private static function color(string $str): string
    {
        return sprintf(
            '<%s>%s</%s>',
            self::COLORING_TAG,
            $str,
            self::COLORING_TAG
        );
    }

    public function dump(XmlMandate $xmlMandate): string
    {
        $attributes = '';

        foreach ($xmlMandate->attributes as $attrKey => $attrValue) {
            $attributes .= "attribute.$attrKey: {$this->color($attrValue)}\n";
        }

        return trim(sprintf(
            "%s: %s\n%s: %s\n%s: %s\n%s: %s\n%s: %s, %s, %s, %s, %s\n%s: %s\n%s: %s\n%s: %s\n%s: %s\n%s",
            ConsoleInterface::OPTION_DESCS['payer-number'],
            self::color($xmlMandate->payerNumber),
            ConsoleInterface::OPTION_DESCS['account'],
            self::color($xmlMandate->account->prettyprint()),
            ConsoleInterface::OPTION_DESCS['id'],
            self::color($xmlMandate->donorId->format('CS-sk')),
            ConsoleInterface::OPTION_DESCS['name'],
            self::color($xmlMandate->name),
            ConsoleInterface::OPTION_DESCS['address'],
            self::color($xmlMandate->address['line1']),
            self::color($xmlMandate->address['line2']),
            self::color($xmlMandate->address['line3']),
            self::color($xmlMandate->address['postalCode']),
            self::color($xmlMandate->address['postalCity']),
            ConsoleInterface::OPTION_DESCS['email'],
            self::color($xmlMandate->email),
            ConsoleInterface::OPTION_DESCS['phone'],
            self::color($xmlMandate->phone),
            ConsoleInterface::OPTION_DESCS['amount'],
            self::color($this->moneyFormatter->format($xmlMandate->donationAmount)),
            ConsoleInterface::OPTION_DESCS['comment'],
            self::color($xmlMandate->comment),
            $attributes
        ));
    }
}
