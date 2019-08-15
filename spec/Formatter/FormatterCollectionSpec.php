<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Formatter;

use byrokrat\giroapp\Formatter\FormatterCollection;
use byrokrat\giroapp\Formatter\FormatterInterface;
use PhpSpec\ObjectBehavior;

class FormatterCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FormatterCollection::class);
    }

    function it_can_add_formatter(FormatterInterface $formatter)
    {
        $formatter->getName()->willReturn('foobar');
        $this->addFormatter($formatter);
        $this->getFormatter('foobar')->shouldReturn($formatter);
    }

    function it_can_get_formatter_names(FormatterInterface $formatter)
    {
        $formatter->getName()->willReturn('foobar');
        $this->addFormatter($formatter);
        $this->getItemKeys()->shouldContain('foobar');
    }
}
