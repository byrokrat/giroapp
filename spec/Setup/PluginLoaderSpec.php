<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Setup;

use byrokrat\giroapp\Setup\PluginLoader;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PluginLoaderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(__DIR__);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PluginLoader::CLASS);
    }

    function it_loads_plugins(EventDispatcherInterface $dispatcher)
    {
        $this->loadPlugins($dispatcher);
        $dispatcher->addSubscriber(new DummyPlugin)->shouldHaveBeenCalled();
    }
}
