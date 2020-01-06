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

namespace byrokrat\giroapp\Domain;

use byrokrat\giroapp\Domain\State\NewMandate;
use byrokrat\giroapp\Domain\State\NewDigitalMandate;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\StateCollection;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use Hashids\Hashids;

class NewDonorProcessor
{
    private const MANDATE_KEY_LENGTH = 16;

    /** @var Hashids */
    private $hashEngine;

    /** @var StateCollection */
    private $stateCollection;

    /** @var SystemClock */
    private $systemClock;

    public function __construct(StateCollection $stateCollection, SystemClock $systemClock)
    {
        $this->stateCollection = $stateCollection;
        $this->systemClock = $systemClock;
        $this->hashEngine = new Hashids(
            '',
            self::MANDATE_KEY_LENGTH,
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        );
    }

    public function processNewDonor(NewDonor $newDonor): Donor
    {
        return new Donor(
            $this->createMandateKey($newDonor->getDonorId(), $newDonor->getAccount()),
            $this->createState($newDonor->getMandateSource()),
            $newDonor->getMandateSource(),
            $newDonor->getPayerNumber(),
            $newDonor->getAccount(),
            $newDonor->getDonorId(),
            '',
            new PostalAddress,
            '',
            '',
            $newDonor->getDonationAmount(),
            '',
            $this->systemClock->getNow(),
            $this->systemClock->getNow(),
            []
        );
    }

    private function createMandateKey(IdInterface $id, AccountNumber $account): string
    {
        $key = $this->hashEngine->encode($id->format('Ss') . substr($account->get16(), 0, -1));

        if (strlen($key) != self::MANDATE_KEY_LENGTH) {
            throw new \LogicException('Mandate key of wrong key size.');
        }

        return $key;
    }

    private function createState(string $mandateSource): StateInterface
    {
        switch ($mandateSource) {
            case MandateSources::MANDATE_SOURCE_PAPER:
            case MandateSources::MANDATE_SOURCE_ONLINE_FORM:
                return $this->stateCollection->getState(NewMandate::getStateId());
            case MandateSources::MANDATE_SOURCE_DIGITAL:
                return $this->stateCollection->getState(NewDigitalMandate::getStateId());
        }

        throw new \LogicException("Invalid mandate source: $mandateSource");
    }
}
