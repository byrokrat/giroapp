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

namespace byrokrat\giroapp\Formatter;

/**
 * Formatter repository
 */
class FormatterContainer
{
    /**
     * @var FormatterInterface[]
     */
    private $formatters = [];

    public function __construct()
    {
        $this->addFormatter(new TableFormatter);
        $this->addFormatter(new CsvFormatter);
        $this->addFormatter(new HumanFormatter);
        $this->addFormatter(new JsonFormatter);
    }

    public function addFormatter(FormatterInterface $formatter): void
    {
        $this->formatters[$formatter->getName()] = $formatter;
    }

    public function getFormatter(string $name): FormatterInterface
    {
        if (!isset($this->formatters[$name])) {
            throw new \RuntimeException("Formatter $name does not exist");
        }

        return $this->formatters[$name];
    }

    public function getFormatterNames(): string
    {
        return '"' . implode('" / "', array_keys($this->formatters)) . '"';
    }
}
