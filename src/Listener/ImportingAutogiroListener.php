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

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\NodeEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use byrokrat\autogiro\Parser\Parser;
use byrokrat\autogiro\Enumerator;
use byrokrat\autogiro\Tree\Node;

/**
 * Parse an autogiro file and fire events based on content
 */
class ImportingAutogiroListener
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function onImportAutogiroEvent(FileEvent $event, string $eventName, Dispatcher $dispatcher): void
    {
        $enum = new Enumerator;

        $enum->onMandateResponseNode(function (Node $node) use ($dispatcher) {
            $dispatcher->dispatch(Events::MANDATE_RESPONSE_EVENT, new NodeEvent($node));
        });

        // TODO dispatch events on all autogiro nodes

        $enum->enumerate($this->parser->parse($event->getFile()->getContent()));
    }
}
