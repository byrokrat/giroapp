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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\DependencyInjection\InputProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Utils\Filesystem;
use byrokrat\giroapp\Utils\File;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Streamer\Stream;

/**
 * Command to import a file from autogirot
 */
class ImportCommand implements CommandInterface
{
    use DispatcherProperty, InputProperty;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Stream
     */
    private $stdin;

    public function __construct(Filesystem $filesystem, Stream $stdin)
    {
        $this->filesystem = $filesystem;
        $this->stdin = $stdin;
    }

    public static function configure(CommandWrapper $wrapper): void
    {
        $wrapper->setName('import');
        $wrapper->setDescription('Import a file from autogirot');
        $wrapper->setHelp('Import a file with data from autogirot');
        $wrapper->addArgument('filename', InputArgument::OPTIONAL, 'The name of the file to import');
        $wrapper->addOption('force', 'f', InputOption::VALUE_NONE, 'Force import even if a pre-condition fails.');
    }

    public function execute(): void
    {
        $file = ($filename = $this->input->getArgument('filename'))
            ? $this->filesystem->readFile($filename)
            : new File('STDIN', $this->stdin->getContent());

        $this->dispatcher->dispatch(
            $this->input->getOption('force') ? Events::FILE_FORCEFULLY_IMPORTED : Events::FILE_IMPORTED,
            new FileEvent(
                "Importing file <info>{$file->getFilename()}</info>",
                $file
            )
        );
    }
}
