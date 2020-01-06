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

use byrokrat\giroapp\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class InitConsole implements ConsoleInterface
{
    private const INI_FILE_NAME = 'giroapp.ini';
    private const DIST_INI_PATH = __DIR__ . '/../../giroapp.ini.dist';

    public function configure(Command $command): void
    {
        $command->setName('init');
        $command->setDescription('Initialize installation');
        $command->setHelp('Create a default giroapp.ini in the current working directory.');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        if (file_exists(self::INI_FILE_NAME)) {
            throw new RuntimeException('Unable to create ' . self::INI_FILE_NAME . ', file already exists.');
        }

        copy(self::DIST_INI_PATH, self::INI_FILE_NAME);

        $iniPath = realpath(self::INI_FILE_NAME);

        $output->writeln(
            <<<EOF
Created configurations at <info>$iniPath</info>

Continue setup by editing configurations using a standard text editor.
Specifically the <info>org_name</info>, <info>org_id</info>, <info>org_bgc_nr</info> and <info>org_bg</info> settings
must be set.

To access configurations from other directories specify the location of
the configuration file by defining a <info>GIROAPP_INI</info> environment variable.

Simply run <info>giroapp</info> with no command specified to se the list of
avaliable commands.
EOF
        );
    }
}
