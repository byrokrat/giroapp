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

namespace byrokrat\giroapp\DI;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\Console\Output\OutputInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;

/**
 * Create the dependency injection container
 */
class ContainerFactory
{
    /**
     * Path to dependency configuration directory
     */
    const CONTAINER_DIR = __DIR__ . '/../../etc';

    /**
     * Name of file containing container spec
     */
    const CONTAINER_FILE_NAME = 'container.yaml';

    /**
     * The service id of the event dispatcher
     */
    const EVENT_DISPATCHER_SERVICE_ID = 'event_dispatcher';

    /**
     * All services tagged with this tag will be registered as event listeners
     */
    const EVENT_LISTENER_TAG = 'event_listener';

    /**
     * All services tagged with this tag will be registered as event subscribers
     */
    const EVENT_SUBSCRIBER_TAG = 'event_subscriber';

    /**
     * @param OutputInterface $output
     * @param string $option  User directory from cli option
     * @param string $envPath User directory from environment
     * @param string $envHome Home directory from environment
     * @param array  $env     A copy of $_ENV
     * @param array  $server  A copy of $_SERVER
     */
    public function createContainer(
        OutputInterface $output,
        string $option = '',
        string $envPath = '',
        string $envHome = '',
        array $env = [],
        array $server = []
    ): ContainerInterface {
        $container = new ContainerBuilder();

        $loader = new YamlFileLoader($container, new FileLocator(self::CONTAINER_DIR));
        $loader->load(self::CONTAINER_FILE_NAME);

        $userDir = (new UserDirectoryLocator)->locateUserDirectory($option, $envPath, $envHome, $env, $server);

        $container->setParameter('user.dir', $userDir);

        $container->set('output', $output);

        $container->addCompilerPass(
            new RegisterListenersPass(
                self::EVENT_DISPATCHER_SERVICE_ID,
                self::EVENT_LISTENER_TAG,
                self::EVENT_SUBSCRIBER_TAG
            )
        );

        $container->compile();

        $container->get('event_dispatcher')->dispatch(
            Events::DEBUG_EVENT,
            new LogEvent("User directory <info>$userDir</info>", ['userDir' => $userDir])
        );

        return $container;
    }
}
