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

namespace byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\DependencyInjection\DonorQueryProperty;
use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Exception\RuntimeException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Validator\StringValidator;
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

    protected function configureDonorArgument(Command $command, bool $required = true): void
    {
        $requiredFlag = $required ? InputArgument::REQUIRED : InputArgument::OPTIONAL;
        $command->addArgument('donor', $requiredFlag, 'Donor identified by mandate key, payer number or name');
        $command->addOption('id-payer-number', null, InputOption::VALUE_NONE, 'Only use payer number as donor id');
        $command->addOption('id-mandate-key', null, InputOption::VALUE_NONE, 'Only use mandate key as donor id');
    }

    public function readDonor(InputInterface $input): Donor
    {
        $taintedId = $input->getArgument('donor');

        if (!is_string($taintedId)) {
            throw new \LogicException('Donor key must be string');
        }

        $donorId = (new StringValidator)->validate('donor', $taintedId);

        if ($input->getOption('id-payer-number') && $input->getOption('id-mandate-key')) {
            throw new RuntimeException("Illegal to use the 'id-payer-number' and 'id-mandate-key' flags toghether.");
        }

        if ($input->getOption('id-payer-number')) {
            return $this->donorQuery->requireByPayerNumber($donorId);
        }

        if ($input->getOption('id-mandate-key')) {
            return $this->donorQuery->requireByMandateKey($donorId);
        }

        if ($donor = $this->donorQuery->findByPayerNumber($donorId)) {
            return $donor;
        }

        if ($donor = $this->donorQuery->findByMandateKey($donorId)) {
            return $donor;
        }

        $regexp = '/'. preg_quote($donorId, '/') . '/i';

        /** @var ?Donor */
        $matchedDonor = null;

        foreach ($this->donorQuery->findAll() as $donor) {
            if (preg_match($regexp, $donor->getName())) {
                if ($matchedDonor) {
                    throw new DonorDoesNotExistException("Unable to find donor '$donorId', more than one match.");
                }
                $matchedDonor = $donor;
            }
        }

        if ($matchedDonor) {
            return $matchedDonor;
        }

        throw new DonorDoesNotExistException("Unable to find donor '$donorId'");
    }
}
