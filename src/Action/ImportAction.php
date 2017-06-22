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

namespace byrokrat\giroapp\Action;

use byrokrat\giroapp\Event\ImportEvent;
use byrokrat\giroapp\Event\ApproveMandateEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use byrokrat\autogiro\Parser\Parser;
use byrokrat\autogiro\Enumerator;
use byrokrat\autogiro\Tree\Record\Response\MandateResponseNode;

/**
 * Parse an autogiro file and fire events based on content
 */
class ImportAction
{
    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function __invoke(ImportEvent $event, string $eventName, EventDispatcherInterface $dispatcher)
    {
        $enum = new Enumerator;

        $enum->onMandateResponseNode(function (MandateResponseNode $node) use ($dispatcher) {

            // TODO check if mandate is approved or not (helper on node?) dispatch accordingly..

            $dispatcher->dispatch(ApproveMandateEvent::NAME, new ApproveMandateEvent($node));
        });

        // TODO dispatch events on all response nodes

        $enum->enumerate($this->parser->parse($event->getContents()));
    }
}
