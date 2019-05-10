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

namespace byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Exception\DonorAlreadyExistsException;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\DonorCollection;
use byrokrat\giroapp\Model\DonorFactory;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\amount\Currency\SEK;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Operators as y;

final class JsonDonorRepository implements DonorRepositoryInterface
{
    const TYPE = 'giroapp/donor:alpha5';

    /** @var CollectionInterface */
    private $collection;

    /** @var DonorFactory */
    private $donorFactory;

    /** @var SystemClock */
    private $systemClock;

    public function __construct(
        CollectionInterface $collection,
        DonorFactory $donorFactory,
        SystemClock $systemClock
    ) {
        $this->collection = $collection;
        $this->donorFactory = $donorFactory;
        $this->systemClock = $systemClock;
    }

    public function findAll(): DonorCollection
    {
        return new DonorCollection(function () {
            foreach ($this->collection as $doc) {
                yield $this->createDonor($doc);
            }
        });
    }

    public function findByMandateKey(string $mandateKey): ?Donor
    {
        if ($this->collection->has($mandateKey)) {
            return $this->createDonor($this->collection->read($mandateKey));
        }

        return null;
    }

    public function requireByMandateKey(string $mandateKey): Donor
    {
        if ($donor = $this->findByMandateKey($mandateKey)) {
            return $donor;
        }

        throw new DonorDoesNotExistException("unknown donor key: $mandateKey");
    }

    public function findByPayerNumber(string $payerNumber): ?Donor
    {
        $doc = $this->collection->findOne(
            y::doc(['payer_number' => y::equals($payerNumber)])
        );

        if (empty($doc)) {
            return null;
        }

        return $this->createDonor($doc);
    }

    public function requireByPayerNumber(string $payerNumber): Donor
    {
        if ($donor = $this->findByPayerNumber($payerNumber)) {
            return $donor;
        }

        throw new DonorDoesNotExistException("unknown payer number: $payerNumber");
    }

    public function addNewDonor(Donor $newDonor): void
    {
        $expr = y::atLeastOne(
            y::doc(['mandate_key' => y::equals($newDonor->getMandateKey())]),
            y::doc(['payer_number' => y::equals($newDonor->getPayerNumber())]),
            y::doc(['donor_id' => y::equals($newDonor->getDonorId())])
        );

        if ($doc = $this->collection->findOne($expr)) {
            throw new DonorAlreadyExistsException(
                sprintf(
                    "Unable to save donor %s due to a conflict with donor %s",
                    $newDonor->getMandateKey(),
                    $doc['mandate_key'] ?? ''
                )
            );
        }

        $this->collection->insert($this->createDoc($newDonor), $newDonor->getMandateKey());
    }

    public function deleteDonor(Donor $donor): void
    {
        $this->requireByMandateKey($donor->getMandateKey());

        $this->collection->delete(
            y::doc(['mandate_key' => y::equals($donor->getMandateKey())])
        );
    }

    public function updateDonorName(Donor $donor, string $newName): void
    {
        $this->updateDonor($donor, ['name' => $newName]);
    }

    public function updateDonorState(Donor $donor, StateInterface $newState, string $stateDesc = ''): void
    {
        $this->updateDonor($donor, [
            'state' => $newState->getStateId(),
            'state_desc' => $stateDesc ?: $newState->getDescription()
        ]);
    }

    public function updateDonorPayerNumber(Donor $donor, string $newPayerNumber): void
    {
        $expr = y::doc([
            'payer_number' => y::equals($newPayerNumber),
            'mandate_key' => y::not(y::equals($donor->getMandateKey())),
        ]);

        if ($doc = $this->collection->findOne($expr)) {
            throw new DonorAlreadyExistsException(
                sprintf(
                    "Unable to set payer number %s due to a conflict with donor %s",
                    $donor->getMandateKey(),
                    $doc['mandate_key'] ?? ''
                )
            );
        }

        $this->updateDonor($donor, ['payer_number' => $newPayerNumber]);
    }

    public function updateDonorAmount(Donor $donor, SEK $newAmount): void
    {
        $this->updateDonor($donor, ['donation_amount' => $newAmount->getAmount()]);
    }

    public function updateDonorAddress(Donor $donor, PostalAddress $newAddress): void
    {
        $this->updateDonor($donor, [
            'address' => [
                'line1' => $newAddress->getLine1(),
                'line2' => $newAddress->getLine2(),
                'line3' => $newAddress->getLine3(),
                'postal_code' => $newAddress->getPostalCode(),
                'postal_city' => $newAddress->getPostalCity(),
            ]
        ]);
    }

    public function updateDonorEmail(Donor $donor, string $newEmail): void
    {
        $this->updateDonor($donor, ['email' => $newEmail]);
    }

    public function updateDonorPhone(Donor $donor, string $newPhone): void
    {
        $this->updateDonor($donor, ['phone' => $newPhone]);
    }

    public function updateDonorComment(Donor $donor, string $newComment): void
    {
        $this->updateDonor($donor, ['comment' => $newComment]);
    }

    public function setDonorAttribute(Donor $donor, string $key, string $value): void
    {
        $attributes = $this->createDoc($donor)['attributes'] ?? [];
        $attributes[$key] = $value;
        $this->updateDonor($donor, ['attributes' => $attributes]);
    }

    public function deleteDonorAttribute(Donor $donor, string $key): void
    {
        $attributes = $this->createDoc($donor)['attributes'] ?? [];
        unset($attributes[$key]);
        $this->updateDonor($donor, ['attributes' => $attributes]);
    }

    private function updateDonor(Donor $donor, array $updatedValues): void
    {
        $this->requireByMandateKey($donor->getMandateKey());

        $doc = array_merge($this->createDoc($donor), $updatedValues);

        $doc['updated'] = $this->systemClock->getNow()->format(\DateTime::W3C);

        $this->collection->insert($doc, $donor->getMandateKey());
    }

    private function createDoc(Donor $donor): array
    {
        return [
            'type' => self::TYPE,
            'mandate_key' => $donor->getMandateKey(),
            'state' => $donor->getState()->getStateId(),
            'state_desc' => $donor->getStateDesc(),
            'mandate_source' => $donor->getMandateSource(),
            'payer_number' => $donor->getPayerNumber(),
            'account' => $donor->getAccount()->getNumber(),
            'donor_id' => $donor->getDonorId()->format('S-sk'),
            'name' => $donor->getName(),
            'address' => [
                'line1' => $donor->getPostalAddress()->getLine1(),
                'line2' => $donor->getPostalAddress()->getLine2(),
                'line3' => $donor->getPostalAddress()->getLine3(),
                'postal_code' => $donor->getPostalAddress()->getPostalCode(),
                'postal_city' => $donor->getPostalAddress()->getPostalCity(),
            ],
            'email' => $donor->getEmail(),
            'phone' => $donor->getPhone(),
            'donation_amount' => $donor->getDonationAmount()->getAmount(),
            'comment' => $donor->getComment(),
            'created' => $donor->getCreated()->format(\DateTime::W3C),
            'updated' => $donor->getUpdated()->format(\DateTime::W3C),
            'attributes' => $donor->getAttributes(),
        ];
    }

    private function createDonor(array $doc): Donor
    {
        return $this->donorFactory->createDonor(
            $doc['mandate_key'],
            $doc['state'],
            $doc['state_desc'],
            $doc['mandate_source'],
            $doc['payer_number'],
            $doc['account'],
            $doc['donor_id'],
            $doc['name'],
            array_values($doc['address']),
            $doc['email'],
            $doc['phone'],
            $doc['donation_amount'],
            $doc['comment'],
            $doc['created'],
            $doc['updated'],
            $doc['attributes']
        );
    }
}
