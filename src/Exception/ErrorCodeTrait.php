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

namespace byrokrat\giroapp\Exception;

use byrokrat\giroapp\Utils\ClassIdExtractor;

trait ErrorCodeTrait
{
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        if (!$code) {
            $const = 'self::' . (string)(new ClassIdExtractor($this));

            if (defined($const)) {
                $code = (int)constant($const);
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
