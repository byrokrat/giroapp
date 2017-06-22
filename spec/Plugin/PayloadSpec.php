<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\Payload;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PayloadSpec extends ObjectBehavior
{
    function let(Event $event, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($event, 'foobar', $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Payload::CLASS);
    }

    function it_contains_an_event(Event $event)
    {
        $this->getEvent()->shouldEqual($event);
    }

    function it_contains_an_event_name()
    {
        $this->getEventName()->shouldEqual('foobar');
    }

    function it_contains_an_event_dispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->getDispatcher()->shouldEqual($dispatcher);
    }
}
