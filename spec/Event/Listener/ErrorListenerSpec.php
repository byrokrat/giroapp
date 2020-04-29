<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\Listener\ErrorListener;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
use PhpSpec\ObjectBehavior;

class ErrorListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ErrorListener::class);
    }

    function it_collects_errors(LogEvent $event)
    {
        $event->getSeverity()->willReturn(LogLevel::ERROR);

        $this->__invoke($event);

        $this->getErrors()->shouldReturn([$event]);
    }

    function it_collects_emergencies(LogEvent $event)
    {
        $event->getSeverity()->willReturn(LogLevel::EMERGENCY);

        $this->__invoke($event);

        $this->getErrors()->shouldReturn([$event]);
    }

    function it_does_not_collect_warnings(LogEvent $event)
    {
        $event->getSeverity()->willReturn(LogLevel::WARNING);

        $this->__invoke($event);

        $this->getErrors()->shouldReturn([]);
    }
}
