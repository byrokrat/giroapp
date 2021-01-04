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

namespace byrokrat\giroapp\Formatter;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\Donor;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output donors as comma separated values
 */
final class CsvFormatter implements FormatterInterface
{
    use DependencyInjection\MoneyFormatterProperty;

    /**
     * @var OutputInterface
     */
    private $output;

    public function getName(): string
    {
        return 'csv';
    }

    public function initialize(OutputInterface $output): void
    {
        $this->output = $output;

        $headers = [
            'mandate-key',
            'state',
            'mandate-source',
            'payer-number',
            'account',
            'id',
            'name',
            'address.line1',
            'address.line2',
            'address.line3',
            'address.postal_code',
            'address.postal_city',
            'email',
            'phone',
            'amount',
            'comment',
            'created',
            'updated',
            'attributes',
        ];

        $this->output->writeln('"' . implode('", "', $headers) . '"');
    }

    public function formatDonor(Donor $donor): void
    {
        $attr = [];

        foreach ($donor->getAttributes() as $key => $value) {
            $attr[] = "$key:$value";
        }

        $data = array_map('addslashes', [
            $donor->getMandateKey(),
            $donor->getState()->getStateId(),
            $donor->getMandateSource(),
            $donor->getPayerNumber(),
            $donor->getAccount()->getNumber(),
            $donor->getDonorId()->format('S-sk'),
            $donor->getName(),
            $donor->getPostalAddress()->getLine1(),
            $donor->getPostalAddress()->getLine2(),
            $donor->getPostalAddress()->getLine3(),
            $donor->getPostalAddress()->getPostalCode(),
            $donor->getPostalAddress()->getPostalCity(),
            $donor->getEmail(),
            $donor->getPhone(),
            $this->moneyFormatter->format($donor->getDonationAmount()),
            $donor->getComment(),
            $donor->getCreated()->format(\DateTime::W3C),
            $donor->getUpdated()->format(\DateTime::W3C),
            implode(' ', $attr)
        ]);

        $this->output->writeln('"' . implode('", "', $data) . '"');
    }

    public function finalize(): void
    {
    }
}
