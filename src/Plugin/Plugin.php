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

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Console\ConsoleInterface;
use byrokrat\giroapp\Db\DriverFactoryInterface;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\State\StateInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Plugin implements PluginInterface
{
    /**
     * @var object[]
     */
    private $objects;

    public function __construct(...$objects)
    {
        $this->objects = $objects;
    }

    final public function loadPlugin(EnvironmentInterface $environment): void
    {
        foreach ($this->objects as $item) {
            if ($item instanceof ApiVersionConstraint) {
                $environment->assertApiVersion($item);
            }
            if ($item instanceof DriverFactoryInterface) {
                $environment->registerDatabaseDriver($item);
            }
            if ($item instanceof ConsoleInterface) {
                $environment->registerConsoleCommand($item);
            }
            if ($item instanceof EventSubscriberInterface) {
                $environment->registerSubscriber($item);
            }
            if ($item instanceof FilterInterface) {
                $environment->registerDonorFilter($item);
            }
            if ($item instanceof FormatterInterface) {
                $environment->registerDonorFormatter($item);
            }
            if ($item instanceof SorterInterface) {
                $environment->registerDonorSorter($item);
            }
            if ($item instanceof StateInterface) {
                $environment->registerDonorState($item);
            }
        }
    }
}
