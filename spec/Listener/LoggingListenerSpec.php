<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\LoggingListener;
use hanneskod\yaysondb\Collection;
use byrokrat\giroapp\Event\LogEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoggingListenerSpec extends ObjectBehavior
{
    function let(Collection $collection)
    {
        $this->beConstructedWith($collection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LoggingListener::CLASS);
    }

    function it_logs_log_events(LogEvent $event, $collection)
    {
        $event->getMessage()->willReturn('msg');
        $event->getContext()->willReturn(['context']);

        $collection->insert([
            'message' => 'msg',
            'severity' => 'ERR',
            'context' => ['context']
        ])->shouldBeCalled();

        $collection->commit()->shouldBeCalled();

        $this->__invoke($event, 'ERR');
    }
}
