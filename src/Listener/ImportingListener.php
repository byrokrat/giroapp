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
use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Exception\InvalidXmlException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

/**
 * Generic file import listener, dispatch events based on file type
 */
class ImportingListener
{
    public function onImportEvent(FileEvent $event, string $eventName, Dispatcher $dispatcher): void
    {
        try {
            $dispatcher->dispatch(
                Events::IMPORT_XML_EVENT,
                new XmlEvent(
                    $event->getFile(),
                    new XmlObject($event->getFile()->getContent())
                )
            );
        } catch (InvalidXmlException $e) {
            $dispatcher->dispatch(Events::IMPORT_AUTOGIRO_EVENT, $event);
        }
    }
}
