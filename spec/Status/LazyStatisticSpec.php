<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Status;

use byrokrat\giroapp\Status\LazyStatistic;
use PhpSpec\ObjectBehavior;

class LazyStatisticSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            'foo',
            'bar',
            function () {
                return 666;
            }
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LazyStatistic::class);
    }

    function it_can_get_name()
    {
        $this->getName()->shouldReturn('foo');
    }

    function it_can_get_description()
    {
        $this->getDescription()->shouldReturn('bar');
    }

    function it_can_get_value()
    {
        $this->getValue()->shouldReturn(666);
    }

    function it_throws_on_invalid_value()
    {
        $this->beConstructedWith(
            '',
            '',
            function () {
                return 'not-an-int';
            }
        );

        $this->shouldThrow(\LogicException::class)->duringGetValue();
    }
}
