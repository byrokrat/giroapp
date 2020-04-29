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

use byrokrat\giroapp\CommandBus\ImportAutogiroFile;
use byrokrat\giroapp\CommandBus\Rollback;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use byrokrat\giroapp\Event\Listener\ErrorListener;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Streamer\Stream;

final class ImportConsole implements ConsoleInterface
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty;

    /** @var FilesystemInterface */
    private $filesystem;

    /** @var ErrorListener */
    private $errorListener;

    public function __construct(FilesystemInterface $filesystem, ErrorListener $errorListener)
    {
        $this->filesystem = $filesystem;
        $this->errorListener = $errorListener;
    }

    public function configure(Command $command): void
    {
        $command
            ->setName('import')
            ->setDescription('Import a file from autogirot')
            ->setHelp('Import one or more files with data from autogirot')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to import'
            )
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Force import')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $files = [];

        $paths = (array)$input->getArgument('path');

        if (empty($paths) && defined('STDIN')) {
            $files[] = new Sha256File('STDIN', (new Stream(STDIN))->getContent());
        }

        foreach ($paths as $path) {
            if ($this->filesystem->isFile($path)) {
                $files[] = $this->filesystem->readFile($path);
                continue;
            }

            foreach ($this->filesystem->readDir($path) as $file) {
                $files[] = $file;
            }
        }

        foreach ($files as $file) {
            $this->commandBus->handle(new ImportAutogiroFile($file));
        }

        // Rollback on errors
        if (!$input->getOption('force') && $this->errorListener->getErrors()) {
            $this->dispatcher->dispatch(
                new LogEvent(
                    'Import failed as there were errors. Changes will be ignored. Use --force to override.',
                    [],
                    LogLevel::ERROR
                )
            );

            $this->commandBus->handle(new Rollback);
        }
    }
}
