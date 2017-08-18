<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\ImportEvent;
use byrokrat\giroapp\Event\LogEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportEventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('', '');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportEvent::CLASS);
    }

    function it_is_a_log_event()
    {
        $this->shouldHaveType(LogEvent::CLASS);
    }

    function it_contains_content()
    {
        $this->beConstructedWith('filename', 'content');
        $this->getContents()->shouldBeLike('content');
    }

    function it_contains_a_filename()
    {
        $this->beConstructedWith('filename', 'content');
        $this->getFilename()->shouldBeLike('filename');
    }

    function it_contains_a_message()
    {
        $this->beConstructedWith('filename', 'content');
        $this->getMessage()->shouldContain('filename');
    }

    function it_contains_a_context()
    {
        $this->beConstructedWith('filename', 'content');
        $this->getContext()->shouldBeLike(['filename' => 'filename']);
    }
}
