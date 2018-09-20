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

use byrokrat\giroapp\DependencyInjection\ValidatorsProperty;
use byrokrat\giroapp\Mapper\SettingsMapper;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * Command to initialize settings in database
 */
final class InitCommand implements CommandInterface
{
    use ValidatorsProperty;

    /**
     * @var SettingsMapper
     */
    private $settingsMapper;

    /**
     * List of options, db keys and description messages
     */
    private const OPTIONS = [
        'org-name' => ['org_name', 'Name of organization'],
        'org-number' => ['org_number', 'Organization id number'],
        'bgc-customer-number' => ['bgc_customer_number', 'BGC customer number'],
        'bankgiro' => ['bankgiro', 'Bankgiro number']
    ];

    public function configure(Adapter $wrapper): void
    {
        $wrapper->setName('init');
        $wrapper->setDescription('Initialize the database');
        $wrapper->setHelp('Initialize giroapp installation');

        foreach (self::OPTIONS as $option => list(, $desc)) {
            $wrapper->addOption($option, null, InputOption::VALUE_REQUIRED, $desc);
        }
    }

    public function __construct(SettingsMapper $settingsMapper)
    {
        $this->settingsMapper = $settingsMapper;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $validators = [
            'org-number' => $this->validators->getIdValidator(),
            'org-name' => $this->validators->getRequiredStringValidator('Org-name'),
            'bgc-customer-number' => $this->validators->getBgcCustomerNumberValidator(),
            'bankgiro' => $this->validators->getBankgiroValidator()
        ];

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        foreach (self::OPTIONS as $option => list($setting, $desc)) {
            $currentVal = $this->settingsMapper->findByKey($setting);

            $newVal = (string)$inputReader->readInput(
                $option,
                Helper\QuestionFactory::createQuestion($desc, $currentVal),
                $validators[$option]
            );

            if (!empty($newVal) && $newVal != $currentVal) {
                $this->settingsMapper->save($setting, $newVal);
            }
        }
    }
}
