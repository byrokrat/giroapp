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

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use byrokrat\giroapp\Event\ImportEvent;

class ImportCommand extends AbstractGiroappCommand
{
    protected function configure()
    {
        parent::configure();
        $this->setName('import');
        $this->setDescription('Import a file from autogirot');
        $this->setHelp('Import a file with data from autogirot');
        $this->addArgument('filename', InputArgument::REQUIRED, 'The name of the file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_readable($input->getArgument('filename')) || !is_file($input->getArgument('filename'))) {
            throw new \RuntimeException("Unable to read file {$input->getArgument('filename')}");
        }

        $this->dispatch(ImportEvent::NAME, new ImportEvent(file_get_contents($input->getArgument('filename'))));
    }
}
