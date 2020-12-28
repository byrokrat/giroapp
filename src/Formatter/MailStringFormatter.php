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

declare(strict_types=1);

namespace byrokrat\giroapp\Formatter;

use byrokrat\giroapp\Domain\Donor;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output donors in a human readable manner
 */
final class MailStringFormatter implements FormatterInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var array<string>
     */
    private $addresses = [];

    public function getName(): string
    {
        return 'mailstr';
    }

    public function initialize(OutputInterface $output): void
    {
        $this->output = $output;
    }

    public function formatDonor(Donor $donor): void
    {
        if (!$donor->getEmail()) {
            return;
        }

        if (!$donor->getName()) {
            $this->addresses[] = $donor->getEmail();
            return;
        }

        $this->addresses[] = sprintf(
            '%s <%s>',
            $donor->getName(),
            $donor->getEmail()
        );
    }

    public function finalize(): void
    {
        $this->output->writeln(implode(', ', $this->addresses));
    }
}
