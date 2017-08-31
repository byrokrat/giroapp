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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Display information on individual donors
 */
class ShowCommand implements CommandInterface
{
    use Traits\DonorArgumentTrait;

    /**
     * @var array Map of option names to donor schema fields
     */
    private static $optionToSchemaMap = [
        'type'           => 'type',
        'mandate-key'    => 'mandateKey',
        'mandate-source' => 'mandateSource',
        'payer-number'   => 'payerNumber',
        'state'          => 'state',
        'account'        => 'account',
        'id'             => 'donorId',
        'name'           => 'name',
        'address'        => 'address',
        'email'          => 'email',
        'phone'          => 'phone',
        'amount'         => 'donationAmount',
        'comment'        => 'comment'
    ];

    public function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('show');
        $wrapper->setDescription('Display donor information');
        $wrapper->setHelp('Display information on individual donors');
        $this->configureDonorArgument($wrapper);
        $wrapper->discardOutputMessages();
        $wrapper->addOption('type', null, InputOption::VALUE_NONE, 'Show donor type identifier');
        $wrapper->addOption('mandate-key', null, InputOption::VALUE_NONE, 'Show mandate key');
        $wrapper->addOption('mandate-source', null, InputOption::VALUE_NONE, 'Show mandate source');
        $wrapper->addOption('payer-number', null, InputOption::VALUE_NONE, 'Show payer number');
        $wrapper->addOption('state', null, InputOption::VALUE_NONE, 'Show payer state');
        $wrapper->addOption('account', null, InputOption::VALUE_NONE, 'Show payer account');
        $wrapper->addOption('id', null, InputOption::VALUE_NONE, 'Show payer state id');
        $wrapper->addOption('name', null, InputOption::VALUE_NONE, 'Show payer name');
        $wrapper->addOption('address', null, InputOption::VALUE_NONE, 'Show postal address');
        $wrapper->addOption('email', null, InputOption::VALUE_NONE, 'Show email address');
        $wrapper->addOption('phone', null, InputOption::VALUE_NONE, 'Show phone number');
        $wrapper->addOption('amount', null, InputOption::VALUE_NONE, 'Show monthly donation amount');
        $wrapper->addOption('comment', null, InputOption::VALUE_NONE, 'Show comment');
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $content = $container->get('donor_schema')->toArray(
            $this->getDonorUsingArgument($input, $container->get('donor_mapper'))
        );

        $showContent = $content;

        foreach (self::$optionToSchemaMap as $option => $field) {
            if (!$input->getOption($option)) {
                unset($showContent[$field]);
            }
        }

        if (empty($showContent)) {
            $showContent = $content;
        }

        foreach ($showContent as $info) {
            $output->writeln(implode((array)$info));
        }
    }
}
