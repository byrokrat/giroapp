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

namespace byrokrat\giroapp\Console\Helper;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Helper that creates simple questions
 */
class QuestionFactory
{
    public static function createQuestion(string $question, $default = null): Question
    {
        return is_null($default)
            ? new Question("$question: ")
            : new Question("$question [<info>$default</info>]: ", $default);
    }

    public static function createChoiceQuestion(string $question, array $choices, string $default): ChoiceQuestion
    {
        $defaultKey = array_search($default, $choices);

        if (false === $defaultKey) {
            throw new \LogicException("Invalid default answer $default");
        }

        unset($choices[$defaultKey]);
        $choices[strtoupper($defaultKey)] = $default;

        return new ChoiceQuestion("$question: ", $choices, strtoupper($defaultKey));
    }
}
