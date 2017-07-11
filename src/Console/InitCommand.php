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

use byrokrat\giroapp\Mapper\SettingsMapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Command to initialize settings in database
 */
class InitCommand implements CommandInterface
{
    /**
     * @var Command
     */
    private $command;

    public function configure(Command $command)
    {
        $this->command = $command;
        $command->setName('init');
        $command->setDescription('Initialize the database');
        $command->setHelp('Initialize giroapp installation');
        $command->addOption('org-name', null, InputOption::VALUE_REQUIRED, 'Name of organization');
        $command->addOption('bgc-customer-number', null, InputOption::VALUE_REQUIRED, 'BGC customer number');
        $command->addOption('bankgiro', null, InputOption::VALUE_REQUIRED, 'Bankgiro account number');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $settingsMapper = $container->get('settings_mapper');
        $this->updateSetting('org_name', 'Name of organization', $input, $output, $settingsMapper);
        $this->updateSetting('bgc_customer_number', 'BGC customer number', $input, $output, $settingsMapper);
        $this->updateSetting('bankgiro', 'Bankgiro account number', $input, $output, $settingsMapper);
    }

    private function updateSetting(
        string $key,
        string $desc,
        InputInterface $input,
        OutputInterface $output,
        SettingsMapper $settingsMapper
    ) {
        $currentValue = $settingsMapper->read($key);

        $newValue = $input->getOption(str_replace('_', '-', $key));

        if (!$newValue) {
            $newValue = $this->command->getHelper('question')->ask(
                $input,
                $output,
                new Question("$desc [<info>$currentValue</info>]: ", $currentValue)
            );
        }

        if ($newValue != $currentValue) {
            $settingsMapper->write($key, $newValue);
            $output->writeln("$desc set to: <info>$newValue</info>");
        }
    }
}
