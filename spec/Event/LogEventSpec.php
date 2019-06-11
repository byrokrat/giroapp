<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LogEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LogEvent::CLASS);
    }

    function it_contains_a_message()
    {
        $this->beConstructedWith('message');
        $this->getMessage()->shouldBeLike('message');
    }

    function it_contains_a_context()
    {
        $this->beConstructedWith('', ['key' => 'value']);
        $this->getContext()->shouldBeLike(['key' => 'value']);
    }

    function it_contains_a_severity()
    {
        $this->beConstructedWith('', [], LogLevel::DEBUG);
        $this->getSeverity()->shouldReturn(LogLevel::DEBUG);
    }

    function it_throws_on_invalid_severity()
    {
        $this->beConstructedWith('', [], 'not-a-valid-severity');
        $this->shouldThrow(\LogicException::CLASS)->duringInstantiation();
    }
}
