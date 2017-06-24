<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\PluginLoader;
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\Payload;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
        $dispatcher->addListener('foobar', Argument::any())->shouldBeCalled();
        $this->loadPlugins($dispatcher);
    }
}

class DummyPlugin implements PluginInterface
{
    public function listensTo(): array
    {
        return ['foobar'];
    }

    public function setup()
    {
    }

    public function execute(Payload $payload)
    {
    }
}
