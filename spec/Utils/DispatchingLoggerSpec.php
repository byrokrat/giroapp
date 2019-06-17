<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\DispatchingLogger;
use byrokrat\giroapp\Event\LogEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DispatchingLoggerSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher)
    {
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DispatchingLogger::CLASS);
    }

    function it_is_a_logger()
    {
        $this->shouldHaveType(LoggerInterface::CLASS);
    }

    function it_throws_on_non_scalar_level()
    {
        $this->shouldThrow(\InvalidArgumentException::CLASS)->duringLog(null, 'message', []);
    }

    function it_throws_on_non_scalar_message()
    {
        $this->shouldThrow(\InvalidArgumentException::CLASS)->duringLog('level', null, []);
    }

    function it_dispatches_log_events($dispatcher)
    {
        $dispatcher->dispatch(new LogEvent('message', ['context'], LogLevel::DEBUG))->shouldBeCalled();
        $this->log(LogLevel::DEBUG, 'message', ['context']);
    }
}
