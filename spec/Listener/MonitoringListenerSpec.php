<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\MonitoringListener;
use byrokrat\giroapp\Event\LogEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MonitoringListenerSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MonitoringListener::CLASS);
    }

    function it_dispatches_log_events($dispatcher, LogEvent $event)
    {
        $this->onLogEvent($event);
        $dispatcher->dispatch(LogEvent::CLASS, $event)->shouldHaveBeenCalled();
    }
}
