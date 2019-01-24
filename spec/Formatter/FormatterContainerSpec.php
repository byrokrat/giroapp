<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Formatter;

use byrokrat\giroapp\Formatter\FormatterContainer;
use byrokrat\giroapp\Formatter\FormatterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormatterContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FormatterContainer::CLASS);
    }

    function it_can_add_filter(FormatterInterface $formatter)
    {
        $formatter->getName()->willReturn('foobar');
        $this->addFormatter($formatter);
        $this->getFormatter('foobar')->shouldReturn($formatter);
    }

    function it_can_get_filter_names(FormatterInterface $formatter)
    {
        $formatter->getName()->willReturn('foobar');
        $this->addFormatter($formatter);
        $this->getFormatterNames()->shouldContain('foobar');
    }
}
