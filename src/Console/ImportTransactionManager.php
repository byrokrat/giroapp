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

use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Event\Listener\ErrorListener;
use byrokrat\giroapp\Event;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

final class ImportTransactionManager
{
    use DependencyInjection\CommandBusProperty;
    use DependencyInjection\DispatcherProperty;

    /** @var ConfigInterface */
    private $alwaysForceImportsConfig;

    /** @var ErrorListener */
    private $errorListener;

    public function __construct(ConfigInterface $alwaysForceImportsConfig, ErrorListener $errorListener)
    {
        $this->alwaysForceImportsConfig = $alwaysForceImportsConfig;
        $this->errorListener = $errorListener;
    }

    public function configure(Command $command): void
    {
        $command
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force import')
            ->addOption('not-force', '', InputOption::VALUE_NONE, 'Do not force import, overrides')
        ;
    }

    public function manageTransaction(InputInterface $input): void
    {
        if (!$this->errorListener->getErrors()) {
            return;
        }

        if (!$input->getOption('not-force')) {
            if (!!$this->alwaysForceImportsConfig->getValue()) {
                return;
            }

            if (!!$input->getOption('force')) {
                return;
            }
        }

        $this->dispatcher->dispatch(
            new Event\ErrorEvent(
                'Import failed as there were errors. Changes will be ignored. Use --force to override.'
            )
        );

        $this->commandBus->handle(new CommandBus\Rollback());
    }
}
