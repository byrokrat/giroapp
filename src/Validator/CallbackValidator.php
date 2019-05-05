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

namespace byrokrat\giroapp\Validator;

use byrokrat\giroapp\Exception\ValidatorException;

final class CallbackValidator implements ValidatorInterface
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function validate(string $key, string $content): string
    {
        try {
            $processed = ($this->callback)($content);
        } catch (\Exception $e) {
            throw new ValidatorException("$key: {$e->getMessage()}");
        }

        if (!is_string($processed)) {
            if (is_scalar($processed) || is_null($processed)) {
                return (string)$processed;
            }

            throw new \LogicException('Callback must return a string value');
        }

        return $processed;
    }
}
