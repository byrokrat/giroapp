<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\AbortingListener;
use byrokrat\giroapp\Event\LogEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AbortingListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AbortingListener::CLASS);
    }

    function it_throws_exceptions(LogEvent $event)
    {
        $event->getMessage()->willReturn('msg');
        $this->shouldThrow('\Exception')->during('onErrorEvent', [$event]);
    }
}
