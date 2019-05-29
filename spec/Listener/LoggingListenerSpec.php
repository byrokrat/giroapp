<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\LoggingListener;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LoggerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LoggingListenerSpec extends ObjectBehavior
{
    function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LoggingListener::CLASS);
    }

    function it_logs($logger, LogEvent $event)
    {
        $event->getMessage()->willReturn('msg');
        $event->getContext()->willReturn(['context']);
        $event->getSeverity()->willReturn('severity');

        $logger->log('severity', 'msg', ['context'])->shouldBeCalled();

        $this->onLogEvent($event);
    }
}
