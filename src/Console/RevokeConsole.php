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
 * Copyright 2016-21 Hannes Forsgård
 */

declare(strict_types=1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\Workflow\Transitions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class RevokeConsole implements ConsoleInterface
{
    use CommandBusProperty;
    use Helper\DonorArgument;
    use Helper\DryRun;

    public function configure(Command $command): void
    {
        $command->setName('revoke');
        $command->setDescription('Revoke a donor mandate');
        $command->setHelp('Revoke a mandate and stop receiving donations from donor');
        $this->configureDonorArgument($command);
        $command->addOption('message', 'm', InputOption::VALUE_REQUIRED, 'Message describing state change');
        $this->configureDryRun($command);
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        /** @var string $msg */
        $msg = $input->getOption('message') ?: 'Revoked by user';

        $this->commandBus->handle(
            new UpdateState($this->readDonor($input), Transitions::INITIATE_REVOCATION, $msg)
        );

        $this->evaluateDryRun($input);
    }
}
