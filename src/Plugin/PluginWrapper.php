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
 * Wrapps a plugin to hook it into the event system
 */
class PluginWrapper
{
    /**
     * @var PluginInterface
     */
    private $plugin;

    public function __construct(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Register listeners to dispatcher
     */
    public function register(EventDispatcherInterface $dispatcher)
    {
        foreach ($this->plugin->listensTo() as $eventName) {
            $dispatcher->addListener($eventName, [$this, 'onEvent']);
        }
    }

    /**
     * Handle a fired event
     */
    public function onEvent(Event $event, string $eventName, EventDispatcherInterface $dispatcher)
    {
        $this->plugin->execute(new Payload($event, $eventName, $dispatcher));
    }
}
