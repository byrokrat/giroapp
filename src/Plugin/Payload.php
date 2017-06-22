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

namespace byrokrat\giroapp\Plugin;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Payload passed to plugins on execution
 */
class Payload
{
    /**
     * @var Event
     */
    private $event;

    /**
     * @var string
     */
    private $eventName;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(Event $event, string $eventName, EventDispatcherInterface $dispatcher)
    {
        $this->event = $event;
        $this->eventName = $eventName;
        $this->dispatcher = $dispatcher;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getDispatcher(): EventDispatcherInterface
    {
        return $this->dispatcher;
    }
}
