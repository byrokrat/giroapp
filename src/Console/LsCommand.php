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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Helper\Table;

/**
 * Command to list donors in database
 */
class LsCommand implements CommandInterface
{
    public function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('ls');
        $wrapper->setDescription('List donors');
        $wrapper->setHelp('List donors in database');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $table = new Table($output);

        $table->setHeaders([
            'mandate-key',
            'payer-number',
            'name',
            'status',
            'export'
        ]);

        foreach ($container->get('byrokrat\giroapp\Mapper\DonorMapper')->findAll() as $donor) {
            $table->addRow([
                $donor->getMandateKey(),
                $donor->getPayerNumber(),
                $donor->getName(),
                $donor->getState()->getId(),
                $donor->getState()->isExportable() ? 'yes' : 'no'
            ]);
        }

        $table->setStyle('compact');
        $table->render();
    }
}
