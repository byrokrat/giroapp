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

namespace byrokrat\giroapp\Formatter;

use byrokrat\giroapp\Model\Donor;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output donors as json collection
 */
final class JsonFormatter implements FormatterInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var array
     */
    private $data;

    public function getName(): string
    {
        return 'json';
    }

    public function setOutput(OutputInterface $output): void
    {
        $this->output = $output;
        $this->data = [];
    }

    public function addDonor(Donor $donor): void
    {
        $this->data[] = [
            'mandate-key' => $donor->getMandateKey(),
            'state' => $donor->getState()->getStateId(),
            'state-desc' => $donor->getStateDesc(),
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
    }

    public function dump(): void
    {
        $data = count($this->data) == 1 ? $this->data[0] : $this->data;
        $this->output->writeln((string)json_encode($data, JSON_PRETTY_PRINT));
    }
}
