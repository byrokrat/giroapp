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
use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Xml\XmlMandateParser;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

/**
 * Parse an xml mandate file and fire event
 */
class ImportingXmlListener
{
    /**
     * @var XmlMandateParser
     */
    private $parser;

    public function __construct(XmlMandateParser $parser)
    {
        $this->parser = $parser;
    }

    public function onImportXmlEvent(XmlEvent $event, string $eventName, Dispatcher $dispatcher): void
    {
        foreach ($this->parser->parse($event->getXmlObject()) as $donor) {
            $dispatcher->dispatch(
                Events::MANDATE_ADDED_EVENT,
                new DonorEvent(
                    sprintf(
                        'Added xml mandate for donor <info>%s</info> with mandate key <info>%s</info>',
                        $donor->getName(),
                        $donor->getMandateKey()
                    ),
                    $donor
                )
            );
        }
    }
}
