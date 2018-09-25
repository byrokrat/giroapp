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
 * Copyright 2016-18 Hannes Forsgård
 */

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Console\CommandInterface;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Xml\XmlFormInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

interface EnvironmentInterface
{
    /**
     * Read a giroapp config value
     */
    public function readConfig(string $key): string;

    /**
     * Register a console command
     */
    public function registerCommand(CommandInterface $command): void;

    /**
     * Register an event subscriber
     */
    public function registerSubscriber(EventSubscriberInterface $subscriber): void;

    /**
     * Register a custom donor filter
     */
    public function registerDonorFilter(FilterInterface $donorFilter): void;

    /**
     * Register a custom donor formatter
     */
    public function registerDonorFormatter(FormatterInterface $donorFormatter): void;

    /**
     * Register an xml form definition
     */
    public function registerXmlForm(XmlFormInterface $xmlForm): void;
}
