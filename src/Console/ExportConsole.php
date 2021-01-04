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

use byrokrat\giroapp\CommandBus\Export;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ExportConsole implements ConsoleInterface
{
    use CommandBusProperty;
    use Helper\DryRun;

    public function configure(Command $command): void
    {
        $command->setName('export');
        $command->setDescription('Export a file to autogirot');
        $command->setHelp('Create a file with new set of autogiro instructions');
        $command->addOption(
            'filename',
            null,
            InputOption::VALUE_REQUIRED,
            'Name of exported file'
        );
        $this->configureDryRun($command);
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        /** @var string */
        $content = $this->commandBus->handle(new Export());

        /** @var string */
        $filename = $input->getOption('filename');

        $filename
            ? file_put_contents($filename, $content)
            : $output->write($content);

        $this->evaluateDryRun($input);
    }
}
