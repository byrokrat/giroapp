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

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\UserDirectoryLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Psr\Container\ContainerInterface;

/**
 * A cli command that have access to the dependency injection container
 */
abstract class AbstractGiroappCommand extends Command
{
    /**
     * Path to app configuration directory
     */
    const CONFIG_DIR = __DIR__ . '/../../etc';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Configure the config option
     */
    protected function configure()
    {
        $this->addOption('config', 'c', InputOption::VALUE_REQUIRED, 'Path to configuration directory');
    }

    /**
     * Setup the dependency injection container
     *
     * @throws \Exception If configure() has not been called
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        if (!$input->hasOption('config')) {
            throw new \Exception('Command not constructed properly, did you call parent::configure()?');
        }

        $userDir = (new UserDirectoryLocator)->locateUserDirectory(
            (string)$input->getOption('config'),
            (string)getenv('GIROAPP_PATH')
        );

        $this->container = new ContainerBuilder();
        $this->container->setParameter('user.dir', $userDir);
        $loader = new YamlFileLoader($this->container, new FileLocator(self::CONFIG_DIR));
        $loader->load('container.yaml');
    }

    /**
     * @throws \Exception If initialize() has not been called
     */
    protected function getContainer(): ContainerInterface
    {
        if (!isset($this->container)) {
            throw new \Exception('Command not constructed properly, did you call parent::initialize()?');
        }

        return $this->container;
    }

    /**
     * Heler to simplify the dispatching of events
     */
    protected function dispatch(string $name, Event $event)
    {
        $this->getContainer()->get('event_dispatcher')->dispatch($name, $event);
    }
}
