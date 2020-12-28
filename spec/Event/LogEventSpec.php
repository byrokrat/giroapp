<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
use PhpSpec\ObjectBehavior;

class LogEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('', LogLevel::DEBUG);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LogEvent::class);
    }

    function it_contains_a_message()
    {
        $this->beConstructedWith('message', LogLevel::DEBUG);
        $this->getMessage()->shouldBeLike('message');
    }

    function it_contains_a_context()
    {
        $this->beConstructedWith('', LogLevel::DEBUG, ['key' => 'value']);
        $this->getContext()->shouldBeLike(['key' => 'value']);
    }

    function it_contains_a_severity()
    {
        $this->beConstructedWith('', LogLevel::DEBUG);
        $this->getSeverity()->shouldReturn(LogLevel::DEBUG);
    }

    function it_throws_on_invalid_severity()
    {
        $this->beConstructedWith('', 'not-a-valid-severity');
        $this->shouldThrow(\LogicException::class)->duringInstantiation();
    }
}
