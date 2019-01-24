<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\FilterContainer;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Filter\NegatedFilter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FilterContainer::CLASS);
    }

    function it_can_add_filter(FilterInterface $filter)
    {
        $filter->getName()->willReturn('foobar');
        $this->addFilter($filter);
        $this->getFilter('foobar')->shouldReturn($filter);
    }

    function it_can_get_filter_names(FilterInterface $filter)
    {
        $filter->getName()->willReturn('foobar');
        $this->addFilter($filter);
        $this->getItemKeys()->shouldContain('foobar');
    }

    function it_can_negate_filter(FilterInterface $filter)
    {
        $filter->getName()->willReturn('foobar');
        $this->addFilter($filter);
        $this->getNegatedFilter('foobar')->shouldBeLike(new NegatedFilter($filter->getWrappedObject()));
    }
}
