<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\InactiveFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\State\StateInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InactiveFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InactiveFilter::CLASS);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::CLASS);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('inactive');
    }

    function it_filters_donors(Donor $donor, StateInterface $state)
    {
        $donor->getState()->willReturn($state);
        $state->isActive()->willReturn(true)->shouldBeCalled();
        $this->filterDonor($donor)->shouldReturn(false);
    }
}
