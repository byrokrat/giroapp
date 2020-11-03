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

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Event\Listener\ErrorListener;
use byrokrat\giroapp\Event;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ImportConsole implements ConsoleInterface
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty;

    /** @var Helper\FileOrStdinInputLocator */
    private $inputLocator;

    /** @var ErrorListener */
    private $errorListener;

    public function __construct(Helper\FileOrStdinInputLocator $inputLocator, ErrorListener $errorListener)
    {
        $this->inputLocator = $inputLocator;
        $this->errorListener = $errorListener;
    }

    public function configure(Command $command): void
    {
        $command
            ->setName('import')
            ->setDescription('Import a file from autogirot')
            ->setHelp('Import one or more files with data from autogirot')
            ->addArgument(
                self::OPTION_PATH,
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                self::OPTION_DESCS[self::OPTION_PATH]
            )
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force import')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->inputLocator->getFiles((array)$input->getArgument('path')) as $file) {
            $this->commandBus->handle(new CommandBus\ImportAutogiroFile($file));
        }

        // Rollback on errors
        if (!$input->getOption('force') && $this->errorListener->getErrors()) {
            $this->dispatcher->dispatch(
                new Event\ErrorEvent(
                    'Import failed as there were errors. Changes will be ignored. Use --force to override.',
                )
            );

            $this->commandBus->handle(new CommandBus\Rollback);
        }
    }
}
