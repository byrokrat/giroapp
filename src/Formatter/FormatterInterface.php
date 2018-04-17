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

namespace byrokrat\giroapp\Formatter;

use byrokrat\giroapp\Model\Donor;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Format donors for output
 */
interface FormatterInterface
{
    /**
     * Get unique fotmatter name
     */
    public function getName(): string;

    /**
     * Set the output this formatter should write to
     */
    public function setOutput(OutputInterface $output): void;

    /**
     * Add donor to format.
     */
    public function addDonor(Donor $donor): void;

    /**
     * Dump formatted content to output
     */
    public function dump(): void;
}
