<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\CombinedFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;

class CombinedFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CombinedFilter::class);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('');
    }

    function it_fails_if_a_filter_fails(FilterInterface $filterA, FilterInterface $filterB, Donor $donor)
    {
        $this->beConstructedWith($filterA, $filterB);
        $filterA->filterDonor($donor)->willReturn(true);
        $filterB->filterDonor($donor)->willReturn(false);
        $this->filterDonor($donor)->shouldReturn(false);
    }

    function it_succedes_if_all_filter_pass(FilterInterface $filterA, FilterInterface $filterB, Donor $donor)
    {
        $this->beConstructedWith($filterA, $filterB);
        $filterA->filterDonor($donor)->willReturn(true);
        $filterB->filterDonor($donor)->willReturn(true);
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
