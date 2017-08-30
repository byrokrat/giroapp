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

namespace byrokrat\giroapp\Console\Traits;

use byrokrat\giroapp\Console\CommandWrapper;
use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Model\Donor;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Methods for fetching donors based on command line argument
 */
trait DonorArgumentTrait
{
    protected function configureDonorArgument(CommandWrapper $wrapper)
    {
        $wrapper->addArgument(
            'donor',
            InputArgument::REQUIRED,
            'Donor identified by mandate key or payer number'
        );

        $wrapper->addOption(
            'force-payer-number',
            false,
            InputOption::VALUE_NONE,
            'Use donor payer number for identification'
        );
    }

    protected function getDonorUsingArgument(InputInterface $input, DonorMapper $donorMapper): Donor
    {
        $key = $input->getArgument('donor');

        if (!$input->getOption('force-payer-number') && $donorMapper->hasKey($key)) {
            return $donorMapper->findByKey($key);
        }

        return $donorMapper->findByActivePayerNumber($key);
    }
}
