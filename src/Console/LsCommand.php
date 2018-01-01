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

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DonorMapperProperty;
use byrokrat\giroapp\DependencyInjection\OutputProperty;
use Symfony\Component\Console\Helper\Table;

/**
 * Command to list donors in database
 */
class LsCommand implements CommandInterface
{
    use DonorMapperProperty, OutputProperty;

    public static function configure(CommandWrapper $wrapper): void
    {
        $wrapper->setName('ls');
        $wrapper->setDescription('List donors');
        $wrapper->setHelp('List donors in database');
    }

    public function execute(): void
    {
        $table = new Table($this->output);

        $table->setHeaders([
            'mandate-key',
            'payer-number',
            'name',
            'status',
            'export'
        ]);

        foreach ($this->donorMapper->findAll() as $donor) {
            $table->addRow([
                $donor->getMandateKey(),
                $donor->getPayerNumber(),
                $donor->getName(),
                $donor->getState()->getStateId(),
                $donor->getState()->isExportable() ? 'yes' : 'no'
            ]);
        }

        $table->setStyle('compact');
        $table->render();
    }
}
