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

namespace byrokrat\giroapp\Listener;

use byrokrat\giroapp\Event\LogEvent;
use hanneskod\yaysondb\Collection;

/**
 * Write events to log
 */
class LoggingListener
{
    /**
     * @var Collection
     */
    private $log;

    public function __construct(Collection $log)
    {
        $this->log = $log;
    }

    public function __invoke(LogEvent $event, string $eventName)
    {
        $this->log->insert([
            'message' => $event->getMessage(),
            'severity' => $eventName,
            'context' => $event->getContext()
        ]);

        $this->log->commit();
    }
}
