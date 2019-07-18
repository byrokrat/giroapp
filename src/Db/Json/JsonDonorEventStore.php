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

use byrokrat\giroapp\Db\DonorEventStoreInterface;
use byrokrat\giroapp\Db\DonorEventEntry;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\Operators as y;

final class JsonDonorEventStore implements DonorEventStoreInterface
{
    /** @var CollectionInterface */
    private $collection;

    public function __construct(CollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    public function addDonorEventEntry(DonorEventEntry $entry): void
    {
        $this->collection->insert(
            [
                'key' => $entry->getMandateKey(),
                'type' => $entry->getType(),
                'time' => $entry->getDateTime()->format(\DateTime::W3C),
                'data' => $entry->getData()
            ]
        );
    }

    public function readEntriesForMandateKey(string $mandateKey): iterable
    {
        foreach ($this->collection->find(y::doc(['key' => y::equals($mandateKey)])) as $data) {
            yield new DonorEventEntry(
                $data['key'] ?? '',
                $data['type'] ?? '',
                new \DateTimeImmutable($data['time'] ?? ''),
                $data['data'] ?? []
            );
        }
    }

    public function readAllEntries(): iterable
    {
        foreach ($this->collection as $data) {
            yield new DonorEventEntry(
                $data['key'] ?? '',
                $data['type'] ?? '',
                new \DateTimeImmutable($data['time'] ?? ''),
                $data['data'] ?? []
            );
        }
    }
}
