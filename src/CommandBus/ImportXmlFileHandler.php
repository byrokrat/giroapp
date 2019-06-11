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

namespace byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Event\XmlFileImported;
use byrokrat\giroapp\Xml\XmlMandateParser;

final class ImportXmlFileHandler
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty;

    /** @var XmlMandateParser */
    private $parser;

    public function __construct(XmlMandateParser $parser)
    {
        $this->parser = $parser;
    }

    public function handle(ImportXmlFile $command): void
    {
        foreach ($this->parser->parse($command->getXmlObject()) as $newDonor) {
            $this->commandBus->handle(new AddDonor($newDonor));
        }

        $this->dispatcher->dispatch(new XmlFileImported($command->getFile()));
    }
}
