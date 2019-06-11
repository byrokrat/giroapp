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

namespace byrokrat\giroapp\Formatter;

use byrokrat\giroapp\Domain\Donor;
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
     * Initialize and set the output formatter should write to
     */
    public function initialize(OutputInterface $output): void;

    /**
     * Add donor to format
     */
    public function formatDonor(Donor $donor): void;

    /**
     * Finalize, possibly dump formatted content to output
     */
    public function finalize(): void;
}
