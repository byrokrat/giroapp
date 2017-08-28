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
     * @var CommandWrapper
     */
    private $wrapper;

    public function configure(CommandWrapper $wrapper)
    {
        $this->wrapper = $wrapper;
        $wrapper->setName('init');
        $wrapper->setDescription('Initialize the database');
        $wrapper->setHelp('Initialize giroapp installation');
        $wrapper->addOption('org-name', null, InputOption::VALUE_REQUIRED, 'Name of organization');
        $wrapper->addOption('bgc-customer-number', null, InputOption::VALUE_REQUIRED, 'BGC customer number');
        $wrapper->addOption('bankgiro', null, InputOption::VALUE_REQUIRED, 'Bankgiro number');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $settingsMapper = $container->get('byrokrat\giroapp\Mapper\SettingsMapper');
        $this->updateSetting('org_name', 'Name of organization', $input, $output, $settingsMapper);
        $this->updateSetting('bgc_customer_number', 'BGC customer number', $input, $output, $settingsMapper);
        $this->updateSetting('bankgiro', 'Bankgiro number', $input, $output, $settingsMapper);
    }

    private function updateSetting(
        string $key,
        string $desc,
        InputInterface $input,
        OutputInterface $output,
        SettingsMapper $settingsMapper
    ) {
        $currentValue = $settingsMapper->findByKey($key);

        $newValue = $input->getOption(str_replace('_', '-', $key));

        if (!$newValue) {
            $newValue = $this->wrapper->getHelper('question')->ask(
                $input,
                $output,
                new Question("$desc [<info>$currentValue</info>]: ", $currentValue)
            );
        }

        if ($newValue != $currentValue) {
            $settingsMapper->save($key, $newValue);
            $output->writeln("$desc set to: <info>$newValue</info>");
        }
    }
}
