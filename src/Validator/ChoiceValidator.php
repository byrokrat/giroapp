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

namespace byrokrat\giroapp\Validator;

use hanneskod\clean\Rule;

final class ChoiceValidator implements ValidatorInterface
{
    use CleanValidatorTrait;

    /**
     * @var string[]
     */
    private $choices;

    /**
     * @param string[] $choices
     */
    public function __construct(array $choices)
    {
        $this->choices = array_change_key_case($choices, CASE_LOWER);
    }

    protected function getRule(): Rule
    {
        return (new Rule())
            ->msg("value must be one of '" . implode("'/'", array_keys($this->choices)) . "'")
            ->match(function (string $val) {
                $lower = strtolower((string)$val);

                if (isset($this->choices[$lower]) || in_array($val, $this->choices)) {
                    return true;
                }

                return false;
            })
            ->post(function (string $val) {
                return $this->choices[strtolower($val)] ?? $val;
            });
    }
}
