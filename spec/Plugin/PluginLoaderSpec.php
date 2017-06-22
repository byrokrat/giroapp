<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\PluginLoader;
use byrokrat\giroapp\Plugin\PluginInterface;
use hanneskod\classtools\Iterator\ClassIterator;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PluginLoaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PluginLoader::CLASS);
    }

    function it_loads_plugins(
        ClassIterator $classIterator,
        EventDispatcherInterface $dispatcher,
        \ReflectionClass $reflectionClass,
        PluginInterface $plugin
    ) {
        $classIterator->enableAutoloading()->shouldBeCalled();
        $classIterator->type(PluginInterface::CLASS)->willReturn($classIterator)->shouldBeCalled();
        $classIterator->where('isInstantiable')->willReturn($classIterator)->shouldBeCalled();
        $classIterator->getIterator()->willReturn(new \ArrayIterator([$reflectionClass->getWrappedObject()]))->shouldBeCalled();

        $reflectionClass->newInstance()->willReturn($plugin->getWrappedObject())->shouldBeCalled();

        $plugin->listensTo()->willReturn(['foobar'])->shouldBeCalled();

        $dispatcher->addListener('foobar', Argument::any())->shouldBeCalled();

        $this->loadPlugins($classIterator, $dispatcher);
    }
}
