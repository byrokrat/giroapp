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

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Streamer\Stream;

final class ImportCommand implements CommandInterface
{
    use DispatcherProperty;

    /** @var FilesystemInterface */
    private $filesystem;

    /** @var Stream */
    private $stdin;

    public function __construct(FilesystemInterface $filesystem, Stream $stdin = null)
    {
        $this->filesystem = $filesystem;
        $this->stdin = $stdin ?: new Stream(STDIN);
    }

    public function configure(Adapter $adapter): void
    {
        $adapter
            ->setName('import')
            ->setDescription('Import a file from autogirot')
            ->setHelp('Import a file with data from autogirot')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
                'One or more paths to import'
            )
            ->addOption(
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Force import even if a precondition fails'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $force = !!$input->getOption('force');

        $paths = (array)$input->getArgument('path');

        if (empty($paths)) {
            $this->importFile(new Sha256File('STDIN', $this->stdin->getContent()), $force);
        }

        foreach ($paths as $path) {
            if ($this->filesystem->isFile($path)) {
                $this->importFile($this->filesystem->readFile($path), $force);
                continue;
            }

            foreach ($this->filesystem->readDir($path) as $file) {
                $this->importFile($file, $force);
            }
        }
    }

    private function importFile(FileInterface $file, bool $force): void
    {
        $this->dispatcher->dispatch(
            $force ? Events::FILE_FORCEFULLY_IMPORTED : Events::FILE_IMPORTED,
            new FileEvent(
                "Importing file <info>{$file->getFilename()}</info>",
                $file
            )
        );
    }
}
