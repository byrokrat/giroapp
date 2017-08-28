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
 * Command to show stats on the current donor database
 */
class StatusCommand implements CommandInterface
{
    public function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('status');
        $wrapper->setDescription('Inspect database status');
        $wrapper->setHelp('Display statistics for current database status');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $table = new Table($output);

        $table->setHeaders([
            'mandate_key',
            'name',
            'payer_number',
            'account',
            'amount',
            'comment',
            'status'
        ]);

        foreach ($container->get('byrokrat\giroapp\Mapper\DonorMapper')->findAll() as $donor) {
            $table->addRow([
                $donor->getMandateKey(),
                $donor->getName(),
                $donor->getPayerNumber(),
                $donor->getAccount(),
                $donor->getDonationAmount()->getString(0),
                $donor->getComment(),
                $donor->getState()->getDescription()
            ]);
        }

        $table->render();
    }
}
