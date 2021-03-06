<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\ApiVersionConstraint;
use PhpSpec\ObjectBehavior;

class ApiVersionConstraintSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('', '');
        $this->shouldHaveType(ApiVersionConstraint::class);
    }

    function it_contains_name()
    {
        $this->beConstructedWith('foo', '');
        $this->getName()->shouldReturn('foo');
    }

    function it_contains_constraint()
    {
        $this->beConstructedWith('', 'foo');
        $this->getConstraint()->shouldReturn('foo');
    }
}
