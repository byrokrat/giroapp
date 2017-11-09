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

namespace byrokrat\giroapp;

use byrokrat\giroapp\Event\LogEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Monitor events and dispatch new log events where applicable
 */
class ApplicationMonitor implements EventSubscriberInterface {
    public static function getSubscribedEvents()
    {
        return [
            Events::IMPORT_EVENT           => ['dispatchInfo', 10],
            Events::MANDATE_ADDED_EVENT    => ['dispatchInfo', 10],
            Events::MANDATE_EDITED_EVENT   => ['dispatchInfo', 10],
            Events::MANDATE_APPROVED_EVENT => ['dispatchInfo', 10],
            Events::MANDATE_REVOKED_EVENT  => ['dispatchInfo', 10],
            Events::MANDATE_DROPPED_EVENT  => ['dispatchInfo', 10],
            Events::MANDATE_INVALID_EVENT  => ['dispatchWarning', 10],
        ];
    }

    public function dispatchInfo(LogEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $dispatcher->dispatch(Events::INFO_EVENT, $event);
    }

    public function dispatchWarning(LogEvent $event, $eventName, EventDispatcherInterface $dispatcher)
    {
        $dispatcher->dispatch(Events::WARNING_EVENT, $event);
    }
}
