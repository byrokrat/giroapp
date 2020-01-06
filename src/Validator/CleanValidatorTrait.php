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

declare(strict_types = 1);

namespace byrokrat\giroapp\Validator;

use byrokrat\giroapp\Exception\ValidatorException;
use hanneskod\clean\Exception as CleanException;
use hanneskod\clean\Rule;

trait CleanValidatorTrait
{
    /**
     * @var Rule
     */
    private $rule;

    abstract protected function getRule(): Rule;

    public function validate(string $key, string $content): string
    {
        try {
            return $this->getCashedRule()->validate($content);
        } catch (CleanException $e) {
            throw new ValidatorException("$key: {$e->getMessage()}");
        }
    }

    private function getCashedRule(): Rule
    {
        if (!isset($this->rule)) {
            $this->rule = $this->getRule();
        }

        return $this->rule;
    }
}
