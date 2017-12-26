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

use byrokrat\giroapp\DependencyInjection\OutputProperty;
use Symfony\Component\Console\Input\InputOption;

/**
 * Display information on individual donors
 */
class ShowCommand implements CommandInterface
{
    use Helper\DonorArgument, OutputProperty;

    private static $options = [
        'mandate-key'    => 'Show mandate key',
        'mandate-source' => 'Show mandate source',
        'payer-number'   => 'Show payer number',
        'state'          => 'Show payer state',
        'account'        => 'Show payer account',
        'id'             => 'Show payer state id',
        'name'           => 'Show payer name',
        'address'        => 'Show postal address',
        'email'          => 'Show email address',
        'phone'          => 'Show phone number',
        'amount'         => 'Show monthly donation amount',
        'comment'        => 'Show comment',
        'created'        => 'Show created date',
        'updated'        => 'Show updated date',
        'attributes'     => 'Show attributes'
    ];

    public static function configure(CommandWrapper $wrapper): void
    {
        $wrapper->setName('show');
        $wrapper->setDescription('Display donor information');
        $wrapper->setHelp('Display information on individual donors');
        self::configureDonorArgument($wrapper);
        foreach (self::$options as $option => $desc) {
            $wrapper->addOption($option, null, InputOption::VALUE_NONE, $desc);
        }
    }

    public function execute(): void
    {
        $donor = $this->getDonor();

        $showContent = $content = [
            'mandate-key' => $donor->getMandateKey(),
            'state' => $donor->getState()->getStateId(),
            'mandate-source' => $donor->getMandateSource(),
            'payer-number' => $donor->getPayerNumber(),
            'account' => $donor->getAccount()->getNumber(),
            'id' => $donor->getDonorId()->format('S-sk'),
            'name' => $donor->getName(),
            'address' => [
                'line1' => $donor->getPostalAddress()->getLine1(),
                'line2' => $donor->getPostalAddress()->getLine2(),
                'line3' => $donor->getPostalAddress()->getLine3(),
                'postal_code' => $donor->getPostalAddress()->getPostalCode(),
                'postal_city' => $donor->getPostalAddress()->getPostalCity()
            ],
            'email' => $donor->getEmail(),
            'phone' => $donor->getPhone(),
            'amount' => $donor->getDonationAmount()->getAmount(),
            'comment' => $donor->getComment(),
            'created' => $donor->getCreated()->format(\DateTime::W3C),
            'updated' => $donor->getUpdated()->format(\DateTime::W3C),
            'attributes' => $donor->getAttributes()
        ];

        foreach (array_keys(self::$options) as $option) {
            if (!$this->input->getOption($option)) {
                unset($showContent[$option]);
            }
        }

        if (empty($showContent)) {
            $showContent = $content;
        }

        foreach ($showContent as $info) {
            $this->output->writeln(implode(' ', (array)$info));
        }
    }
}
