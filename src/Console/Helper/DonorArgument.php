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
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\DependencyInjection\DonorQueryProperty;
use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Validator\DonorKeyValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Methods for fetching donors based on command line argument
 */
trait DonorArgument
{
    use DonorQueryProperty;

    protected function configureDonorArgument(Command $command): void
    {
        $command->addArgument(
            'donor',
            InputArgument::REQUIRED,
            'Donor identified by mandate key or payer number'
        );

        $command->addOption(
            'force-payer-number',
            null,
            InputOption::VALUE_NONE,
            'Use donor payer number for identification'
        );
    }

    public function readDonor(InputInterface $input): Donor
    {
        $taintedKey = $input->getArgument('donor');

        if (!is_string($taintedKey)) {
            throw new \LogicException('Donor key must be string');
        }

        $key = (new DonorKeyValidator)->validate('donor', $taintedKey);

        if (!$input->getOption('force-payer-number') && ($donor = $this->donorQuery->findByMandateKey($key))) {
            return $donor;
        }

        return $this->donorQuery->requireByPayerNumber($key);
    }
}
