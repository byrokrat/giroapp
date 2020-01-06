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

namespace byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Db\DonorEventStoreInterface;
use byrokrat\giroapp\Db\DonorEventEntry;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Utils\ClassIdExtractor;
use byrokrat\giroapp\Utils\SystemClock;

final class DonorEventRecorder implements ListenerInterface
{
    /** @var DonorEventStoreInterface */
    private $eventStore;

    /** @var DonorEventNormalizer */
    private $normalizer;

    /** @var SystemClock */
    private $clock;

    public function __construct(
        DonorEventStoreInterface $eventStore,
        DonorEventNormalizer $normalizer,
        SystemClock $clock
    ) {
        $this->eventStore = $eventStore;
        $this->normalizer = $normalizer;
        $this->clock = $clock;
    }

    public function __invoke(DonorEvent $event): void
    {
        $this->eventStore->addDonorEventEntry(
            new DonorEventEntry(
                $event->getDonor()->getMandateKey(),
                (string)new ClassIdExtractor($event),
                $this->clock->getNow(),
                $this->normalizer->normalizeEvent($event)
            )
        );
    }
}
