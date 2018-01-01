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

namespace byrokrat\giroapp\State;

use byrokrat\giroapp\States;
use byrokrat\giroapp\Builder\DateBuilder;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\Writer;

class MandateApprovedState extends AbstractState
{
    /**
     * @var DateBuilder
     */
    private $dateBuilder;

    public function __construct(DateBuilder $dateBuilder)
    {
        $this->dateBuilder = $dateBuilder;
    }

    public function getDescription(): string
    {
        return 'Mandate has been approved by the bank';
    }

    public function getStateId(): string
    {
        return States::MANDATE_APPROVED;
    }

    public function getNextStateId(): string
    {
        return States::ACTIVE;
    }

    public function export(Donor $donor, Writer $writer): void
    {
        if ($donor->getDonationAmount()->isPositive()) {
            $writer->addMonthlyTransaction(
                $donor->getPayerNumber(),
                $donor->getDonationAmount(),
                $this->dateBuilder->buildDate(),
                $donor->getMandateKey()
            );
        }
    }
}
