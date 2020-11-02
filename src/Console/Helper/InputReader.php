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

namespace byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Console\ConsoleInterface;
use byrokrat\giroapp\Validator\ValidatorInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * Read option or fallback to interactive question
 */
class InputReader
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var QuestionHelper
     */
    private $questionHelper;

    public function __construct(InputInterface $input, OutputInterface $output, QuestionHelper $questionHelper)
    {
        $this->input = $input;
        $this->output = $output;
        $this->questionHelper = $questionHelper;
    }

    public function confirm(string $question, bool $default = true): bool
    {
        return !!$this->questionHelper->ask(
            $this->input,
            $this->output,
            new ConfirmationQuestion($question, $default)
        );
    }

    public function readInput(string $key, Question $question, ValidatorInterface $validator): string
    {
        $value = null;

        if ($this->input->hasOption($key)) {
            $value = $this->input->getOption($key);
        }

        if (is_string($value)) {
            return $validator->validate($key, $value);
        }

        $value = (string)$this->questionHelper->ask(
            $this->input,
            $this->output,
            $question->setValidator(function ($answer) use ($key, $validator) {
                return $validator->validate($key, (string)$answer);
            })
        );

        return $this->input->isInteractive() ? $value : $validator->validate($key, $value);
    }

    public function readOptionalInput(string $key, string $default, ValidatorInterface $validator): string
    {
        $value = null;

        if ($this->input->hasOption($key)) {
            $value = $this->input->getOption($key);
        }

        if (is_string($value)) {
            return $validator->validate($key, $value);
        }

        $desc = ConsoleInterface::OPTION_DESCS[$key] ?? $key;

        // Confirm if user wants to edit, return default if not
        if (!$this->confirm("$desc: <comment>$default</comment>\nEdit [<info>y/N</info>]? ", false)) {
            return $default;
        }

        $value = (string)$this->questionHelper->ask(
            $this->input,
            $this->output,
            (new Question("New $desc: "))->setValidator(function ($answer) use ($key, $validator) {
                return $validator->validate($key, (string)$answer);
            })
        );

        return $this->input->isInteractive() ? $value : $validator->validate($key, $value);
    }
}
