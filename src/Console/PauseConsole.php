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

use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\State\Active;
use byrokrat\giroapp\State\MandateApproved;
use byrokrat\giroapp\State\Paused;
use byrokrat\giroapp\State\PauseMandate;
use byrokrat\giroapp\Exception\InvalidStateTransitionException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class PauseConsole implements ConsoleInterface
{
    use CommandBusProperty, Helper\DonorArgument;

    public function configure(Command $command): void
    {
        $command->setName('pause');
        $command->setDescription('Pause a donor mandate');
        $command->setHelp('Pause a mandate and temporarily stop receiving donations from donor');
        $this->configureDonorArgument($command);
        $command->addOption('restart', null, InputOption::VALUE_NONE, 'Restart a previously paused donor');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->readDonor($input);

        if ($input->getOption('restart')) {
            if (!$donor->getState() instanceof Paused) {
                throw new InvalidStateTransitionException('Unable to restart donor that is not paused.');
            }

            $this->commandBus->handle(new UpdateState($donor, MandateApproved::CLASS));

            return;
        }

        if (!$donor->getState() instanceof Active) {
            throw new InvalidStateTransitionException('Unable to pause non active donor.');
        }

        $this->commandBus->handle(new UpdateState($donor, PauseMandate::CLASS));
    }
}
