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

/**
 * Command to initialize settings in database
 */
class InitCommand implements CommandInterface
{
    use Traits\ValidatorsTrait;

    /**
     * @var SettingsMapper
     */
    private $settingsMapper;

    /**
     * @var Option\OptionReader
     */
    private $optionReader;

    /**
     * @var array List of options, db keys and description messages
     */
    private static $options = [
        'org-name' => ['org_name', 'Name of organization'],
        'org-number' => ['org_number', 'Organization id number'],
        'bgc-customer-number' => ['bgc_customer_number', 'BGC customer number'],
        'bankgiro' => ['bankgiro', 'Bankgiro number']
    ];

    public static function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('init');
        $wrapper->setDescription('Initialize the database');
        $wrapper->setHelp('Initialize giroapp installation');

        foreach (self::$options as $option => list(, $desc)) {
            $wrapper->addOption($option, null, InputOption::VALUE_REQUIRED, $desc);
        }
    }

    public function __construct(SettingsMapper $settingsMapper, Option\OptionReader $optionReader)
    {
        $this->settingsMapper = $settingsMapper;
        $this->optionReader = $optionReader;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $validators = [
            'org-number' => $this->getOrganizationNumberValidator(),
            'bgc-customer-number' => $this->getBgcCustomerNumberValidator(),
            'bankgiro' => $this->getBankgiroValidator()
        ];

        foreach (self::$options as $option => list($setting, $desc)) {
            $currentVal = $this->settingsMapper->findByKey($setting);

            $newVal = (string)$this->optionReader->readOption(
                $option,
                $desc,
                $currentVal,
                $validators[$option] ?? null
            );

            if ($newVal != $currentVal) {
                $this->settingsMapper->save($setting, $newVal);
                $output->writeln("$desc set to: <info>$newVal</info>");
            }
        }
    }
}
