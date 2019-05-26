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

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\CommandBus\RemoveDonor;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\DependencyInjection\DonorQueryProperty;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PurgeConsole implements ConsoleInterface
{
    use CommandBusProperty, DonorQueryProperty;

    public function configure(Command $command): void
    {
        $command->setName('purge');
        $command->setDescription('Completely remove all inactive donors');
        $command->setHelp('Completely remove all incative donors from the database');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->donorQuery->findAll() as $donor) {
            if ($donor->getState()->isPurgeable()) {
                $this->commandBus->handle(new RemoveDonor($donor));
            }
        }
    }
}
