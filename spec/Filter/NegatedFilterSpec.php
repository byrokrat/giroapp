<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\NegatedFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Model\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NegatedFilterSpec extends ObjectBehavior
{
    function let(FilterInterface $negatedFilter)
    {
        $this->beConstructedWith($negatedFilter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NegatedFilter::CLASS);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::CLASS);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('');
    }

    function it_negates_filter($negatedFilter, Donor $donor)
    {
        $negatedFilter->filterDonor($donor)->willReturn(true)->shouldBeCalled();
        $this->filterDonor($donor)->shouldReturn(false);
    }
}
