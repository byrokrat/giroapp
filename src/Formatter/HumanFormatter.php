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

namespace byrokrat\giroapp\Formatter;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\Donor;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Output donors in a human readable manner
 */
final class HumanFormatter implements FormatterInterface
{
    use DependencyInjection\MoneyFormatterProperty;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var bool
     */
    private $firstItem;

    public function getName(): string
    {
        return 'human';
    }

    public function initialize(OutputInterface $output): void
    {
        $this->output = $output;
        $this->firstItem = true;
    }

    public function formatDonor(Donor $donor): void
    {
        if (!$this->firstItem) {
            $this->output->writeln("");
        }

        $this->firstItem = false;

        $address = array_filter([
            $donor->getPostalAddress()->getLine1(),
            $donor->getPostalAddress()->getLine2(),
            $donor->getPostalAddress()->getLine3(),
            $donor->getPostalAddress()->getPostalCode(),
            $donor->getPostalAddress()->getPostalCity()
        ]);

        $this->output->writeln("mandate-key: <info>{$donor->getMandateKey()}</info>");
        $this->output->writeln("state: <info>{$donor->getState()->getStateId()}</info>");
        $this->output->writeln("mandate-source: <info>{$donor->getMandateSource()}</info>");
        $this->output->writeln("payer-number: <info>{$donor->getPayerNumber()}</info>");
        $this->output->writeln("account: <info>{$donor->getAccount()}</info>");
        $this->output->writeln("id: <info>{$donor->getDonorId()->format('S-sk')}</info>");
        $this->output->writeln("name: <info>{$donor->getName()}</info>");
        $this->output->writeln("address: <info>" . implode(", ", $address) . "</info>");
        $this->output->writeln("email: <info>{$donor->getEmail()}</info>");
        $this->output->writeln("phone: <info>{$donor->getPhone()}</info>");
        $this->output->writeln("amount: <info>{$this->moneyFormatter->format($donor->getDonationAmount())}</info>");
        $this->output->writeln("comment: <info>{$donor->getComment()}</info>");
        $this->output->writeln("created: <info>{$donor->getCreated()->format('Y-m-d')}</info>");
        $this->output->writeln("updated: <info>{$donor->getUpdated()->format('Y-m-d')}</info>");

        foreach ($donor->getAttributes() as $attrKey => $attrValue) {
            $this->output->writeln("attribute.<comment>$attrKey</comment>: <info>$attrValue</info>");
        }
    }

    public function finalize(): void
    {
    }
}
