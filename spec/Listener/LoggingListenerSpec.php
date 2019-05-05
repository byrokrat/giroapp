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

    function it_logs_errors($logger, LogEvent $event)
    {
        $event->getMessage()->willReturn('msg');
        $event->getContext()->willReturn(['context']);

        $logger->error('msg', ['context'])->shouldBeCalled();

        $this->onError($event);
    }

    function it_logs_warnings($logger, LogEvent $event)
    {
        $event->getMessage()->willReturn('msg');
        $event->getContext()->willReturn(['context']);

        $logger->warning('msg', ['context'])->shouldBeCalled();

        $this->onWarning($event);
    }

    function it_logs_infos($logger, LogEvent $event)
    {
        $event->getMessage()->willReturn('msg');
        $event->getContext()->willReturn(['context']);

        $logger->info('msg', ['context'])->shouldBeCalled();

        $this->onInfo($event);
    }

    function it_logs_debugs($logger, LogEvent $event)
    {
        $event->getMessage()->willReturn('msg');
        $event->getContext()->willReturn(['context']);

        $logger->debug('msg', ['context'])->shouldBeCalled();

        $this->onDebug($event);
    }
}
