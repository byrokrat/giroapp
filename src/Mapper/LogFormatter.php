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

namespace byrokrat\giroapp\Mapper;

use hanneskod\yaysondb\Engine\DecoderInterface;

/**
 * Formats log messages
 */
class LogFormatter implements DecoderInterface
{
    public function encode(array $docs): string
    {
        return sprintf(
            '[%s] [%s] %s %s',
            date(DATE_RFC2822),
            $docs['severity'],
            strip_tags($docs['message']),
            $docs['context'] ? json_encode((object)$docs['context']) : ''
        );
    }

    public function decode(string $source): array
    {
        return [];
    }
}
