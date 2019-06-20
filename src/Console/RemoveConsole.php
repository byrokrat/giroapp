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

use byrokrat\giroapp\CommandBus\ForceRemoveDonor;
use byrokrat\giroapp\CommandBus\RemoveDonor;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\Domain\State\Inactive;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class RemoveConsole implements ConsoleInterface
{
    use CommandBusProperty, Helper\DonorArgument;

    public function configure(Command $command): void
    {
        $command->setName('remove');
        $command->setDescription('Completely remove donors');
        $command->setHelp('Completely remove donors from the database');
        $this->configureDonorArgument($command, false);
        $command->addOption('all', 'a', InputOption::VALUE_NONE, 'Remove all inactive donors');
        $command->addOption('force', 'f', InputOption::VALUE_NONE, 'Force removal (ignored if -a is used)');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        if ($input->getOption('all')) {
            foreach ($this->donorQuery->findAll() as $donor) {
                if ($donor->getState() instanceof Inactive) {
                    $this->commandBus->handle(new RemoveDonor($donor));
                }
            }

            return;
        }

        $command = $input->getOption('force')
            ? new ForceRemoveDonor($this->readDonor($input))
            : new RemoveDonor($this->readDonor($input));

        $this->commandBus->handle($command);
    }
}
