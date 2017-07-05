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

namespace byrokrat\giroapp\Model\DonorState;

use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\Writer;

class MandateApprovedState extends AbstractState
{
    public function getDescription(): string
    {
        return 'Mandate has been approved by the bank';
    }

    public function isExportable(): bool
    {
        return true;
    }

    public function export(Donor $donor, Writer $writer)
    {
        if ($donor->getDonationAmount()->isPositive()) {
            // TODO how do we compute date??
            // should probably be a setting. How do we read it here??
            $date = new \DateTime;

            // TODO should we keep a reference to this transaction??
            // would be cool to use $donor->getMandateKey(), but refs can be only 16 chars...
            $ref = '';

            $writer->addMonthlyTransaction($donor->getPayerNumber(), $donor->getDonationAmount(), $date, $ref);
            $donor->setState(new ActiveState);
        }
    }
}
