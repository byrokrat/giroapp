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

namespace byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\CommandBus\Rollback;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

trait DryRun
{
    use CommandBusProperty;

    protected function configureDryRun(Command $command): void
    {
        $command->addOption(
            'dry',
            'd',
            InputOption::VALUE_NONE,
            'Automatically discard changes to persistent storage'
        );
    }

    protected function evaluateDryRun(InputInterface $input): void
    {
        if ($input->getOption('dry')) {
            $this->commandBus->handle(new Rollback());
        }
    }
}
