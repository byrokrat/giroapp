<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileEventSpec extends ObjectBehavior
{
    function let(FileInterface $file)
    {
        $this->beConstructedWith('', $file);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileEvent::CLASS);
    }

    function it_is_a_log_event()
    {
        $this->shouldHaveType(LogEvent::CLASS);
    }

    function it_contains_a_file($file)
    {
        $this->getFile()->shouldReturn($file);
    }

    function it_contains_a_message($file)
    {
        $this->beConstructedWith('message', $file);
        $this->getMessage()->shouldReturn('message');
    }
}
