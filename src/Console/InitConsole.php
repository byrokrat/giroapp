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
            throw new \RuntimeException('Unable to create ' . self::INI_FILE_NAME . ', file already exists.');
        }

        copy(self::DIST_INI_PATH, self::INI_FILE_NAME);

        $iniPath = realpath(self::INI_FILE_NAME);

        $output->writeln("Created configurations at '$iniPath'.");
        $output->writeln("");
        $output->writeln("Continue setup by editing configurations using a standard text editor.");
        $output->writeln("Specifically the 'org_name', 'org_id', 'org_bgc_nr' and 'org_bg' settings");
        $output->writeln("must be specified.");
        $output->writeln("");
        $output->writeln("To access configurations from other directories specify the location of");
        $output->writeln("the configuration file by defining a GIROAPP_INI environment variable.");
    }
}
