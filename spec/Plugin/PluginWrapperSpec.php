<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\PluginWrapper;
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\Payload;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PluginWrapperSpec extends ObjectBehavior
{
    function let(PluginInterface $plugin)
    {
        $this->beConstructedWith($plugin);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PluginWrapper::CLASS);
    }

    function it_registers_event_listeners(EventDispatcherInterface $dispatcher, $plugin)
    {
        $plugin->listensTo()->willReturn(['event'])->shouldBeCalled();
        $this->register($dispatcher);
        $dispatcher->addListener('event', [$this, 'onEvent'])->shouldHaveBeenCalled();
    }

    function it_handles_fired_events(Event $event, EventDispatcherInterface $dispatcher, $plugin)
    {
        $this->onEvent($event, 'name', $dispatcher);
        $payload = new Payload($event->getWrappedObject(), 'name', $dispatcher->getWrappedObject());
        $plugin->execute($payload)->shouldHaveBeenCalled();
    }
}
