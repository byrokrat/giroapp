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

use byrokrat\giroapp\Model\Donor;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * Output donors in tabular style
 */
class TableFormatter implements FormatterInterface
{
    /**
     * @var Table
     */
    private $table;

    public function getName(): string
    {
        return 'table';
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->table = new Table($output);
        $this->table->setHeaders([
            'mandate-key',
            'payer-number',
            'name',
            'status',
            'export'
        ]);
        $this->table->setStyle('compact');
    }

    public function addDonor(Donor $donor): void
    {
        $this->table->addRow([
            $donor->getMandateKey(),
            $donor->getPayerNumber(),
            $donor->getName(),
            $donor->getState()->getStateId(),
            $donor->getState()->isExportable() ? 'yes' : 'no'
        ]);
    }

    public function dump(): void
    {
        $this->table->render();
    }
}
