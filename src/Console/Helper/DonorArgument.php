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

namespace byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\DependencyInjection\DonorMapperProperty;
use byrokrat\giroapp\DependencyInjection\ValidatorsProperty;
use byrokrat\giroapp\Console\Adapter;
use byrokrat\giroapp\Model\Donor;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Methods for fetching donors based on command line argument
 */
trait DonorArgument
{
    use DonorMapperProperty, ValidatorsProperty;

    protected function configureDonorArgument(Adapter $wrapper): void
    {
        $wrapper->addArgument(
            'donor',
            InputArgument::REQUIRED,
            'Donor identified by mandate key or payer number'
        );

        $wrapper->addOption(
            'force-payer-number',
            null,
            InputOption::VALUE_NONE,
            'Use donor payer number for identification'
        );
    }

    /**
     * @throws \RuntimeException if Donor can not be found
     */
    public function getDonor(InputInterface $input): Donor
    {
        $key = $this->validators->getDonorKeyValidator()($input->getArgument('donor'));

        if (!$input->getOption('force-payer-number') && $this->donorMapper->hasKey($key)) {
            return $this->donorMapper->findByKey($key);
        }

        try {
            return $this->donorMapper->findByActivePayerNumber($key);
        } catch (\RuntimeException $e) {
            foreach ($this->donorMapper->findByPayerNumber($key) as $donor) {
                return $donor;
            }
        }

        throw new \RuntimeException("Unable to find donor $key");
    }
}
