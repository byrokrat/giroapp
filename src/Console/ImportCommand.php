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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Command to import a file from autogirot
 */
class ImportCommand implements CommandInterface
{
    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public static function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('import');
        $wrapper->setDescription('Import a file from autogirot');
        $wrapper->setHelp('Import a file with data from autogirot');
        $wrapper->addArgument('filename', InputArgument::REQUIRED, 'The name of the file to import');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_readable($input->getArgument('filename')) || !is_file($input->getArgument('filename'))) {
            throw new \RuntimeException("Unable to read file {$input->getArgument('filename')}");
        }

        $this->dispatcher->dispatch(
            Events::IMPORT_EVENT,
            new FileEvent(
                $input->getArgument('filename'),
                file_get_contents($input->getArgument('filename'))
            )
        );
    }
}
