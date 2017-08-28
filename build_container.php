<?php

declare(strict_types = 1);

namespace byrokrat\giroapp;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;

require __DIR__ . '/vendor/autoload.php';

/**
 * Name of file containing container spec
 */
define('CONTAINER_SOURCE', __DIR__ . '/etc/container.yaml');

/**
 * Target file name for compiled container
 */
define('CONTAINER_TARGET', __DIR__ . '/src/ProjectServiceContainer.php');

/**
 * The service id of the event dispatcher
 */
define('EVENT_DISPATCHER_SERVICE_ID', 'event_dispatcher');

/**
 * All services tagged with this tag will be registered as event listeners
 */
define('EVENT_LISTENER_TAG', 'event_listener');

/**
 * All services tagged with this tag will be registered as event subscribers
 */
define('EVENT_SUBSCRIBER_TAG', 'event_subscriber');

/**
 * Create empty container
 */
$container = new ContainerBuilder();

/**
 * Load service definitions into container
 */
(new YamlFileLoader($container, new FileLocator(dirname(CONTAINER_SOURCE))))->load(basename(CONTAINER_SOURCE));

/**
 * Add pass to autoregister tagged event listeners
 */
$container->addCompilerPass(
    new RegisterListenersPass(EVENT_DISPATCHER_SERVICE_ID, EVENT_LISTENER_TAG, EVENT_SUBSCRIBER_TAG)
);

/**
 * Compile container
 */
$container->compile();

/**
 * Dump to file system
 */
file_put_contents(CONTAINER_TARGET, (new PhpDumper($container))->dump([
    'namespace' => __NAMESPACE__,
    'class' => pathinfo(CONTAINER_TARGET, PATHINFO_FILENAME)
]));
