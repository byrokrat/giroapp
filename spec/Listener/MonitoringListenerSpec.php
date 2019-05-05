<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\MonitoringListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MonitoringListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MonitoringListener::CLASS);
    }

    function it_dispatches_debug(LogEvent $event, EventDispatcherInterface $dispatcher)
    {
        $this->dispatchDebug($event, '', $dispatcher);
        $dispatcher->dispatch(Events::DEBUG, $event)->shouldHaveBeenCalled();
    }

    function it_dispatches_info(LogEvent $event, EventDispatcherInterface $dispatcher)
    {
        $this->dispatchInfo($event, '', $dispatcher);
        $dispatcher->dispatch(Events::INFO, $event)->shouldHaveBeenCalled();
    }

    function it_dispatches_warning(LogEvent $event, EventDispatcherInterface $dispatcher)
    {
        $this->dispatchWarning($event, '', $dispatcher);
        $dispatcher->dispatch(Events::WARNING, $event)->shouldHaveBeenCalled();
    }
}
