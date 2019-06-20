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
use byrokrat\giroapp\Event\Listener\ListenerInterface;
use byrokrat\giroapp\Sorter\SorterInterface;
use Psr\EventDispatcher\ListenerProviderInterface;

class Plugin implements PluginInterface
{
    /** @var array */
    private $objects;

    /** @var string */
    private $pluginName = '';

    public function __construct(...$objects)
    {
        $this->objects = $objects;
    }

    final public function loadPlugin(EnvironmentInterface $environment): void
    {
        foreach ($this->objects as $item) {
            switch (true) {
                case $item instanceof ApiVersionConstraint:
                    $environment->assertApiVersion($item);
                    $this->pluginName = $item->getName();
                    break;
                case $item instanceof DriverFactoryInterface:
                    $environment->registerDatabaseDriver($item);
                    break;
                case $item instanceof ConsoleInterface:
                    $environment->registerConsoleCommand($item);
                    break;
                case $item instanceof ListenerInterface:
                    if (!is_callable($item)) {
                        throw new \LogicException(sprintf(
                            'Class %s implements the ListenerInterface but is not callable',
                            get_class($item)
                        ));
                    }
                    $environment->registerListener($item);
                    break;
                case $item instanceof ListenerProviderInterface:
                    $environment->registerListenerProvider($item);
                    break;
                case $item instanceof FilterInterface:
                    $environment->registerDonorFilter($item);
                    break;
                case $item instanceof FormatterInterface:
                    $environment->registerDonorFormatter($item);
                    break;
                case $item instanceof SorterInterface:
                    $environment->registerDonorSorter($item);
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf(
                        "Unknown item type '%s' in plugin '%s'",
                        is_object($item) ? get_class($item) : gettype($item),
                        $this->pluginName
                    ));
            }
        }
    }
}
