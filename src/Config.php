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

namespace byrokrat\giroapp;

use Aura\Di\Container;
use Aura\Di\ContainerConfig;
use Symfony\Component\EventDispatcher\EventDispatcher;
use byrokrat\autogiro\Parser\ParserFactory;
use hanneskod\classtools\Iterator\ClassIterator;
use Symfony\Component\Finder\Finder;

/**
 * Dependency injection configurations
 */
class Config extends ContainerConfig
{
    /**
     * @var string Path to configuration directory
     */
    private $configPath;

    /**
     * @param string $configPath Path to configuration directory
     */
    public function __construct(string $configPath)
    {
        $this->configPath = $configPath;
    }

    public function define(Container $di)
    {
        $di->set('event_dispatcher', $di->lazy(function () use ($di) {
            $dispatcher = new EventDispatcher;

            $dispatcher->addListener(
                Events::IMPORT,
                new Action\ImportAction((new ParserFactory)->createParser())
            );

            (new Plugin\PluginLoader)->loadPlugins(
                new ClassIterator((new Finder)->in($this->configPath . '/plugins')),
                $dispatcher
            );

            return $dispatcher;
        }));
    }
}
