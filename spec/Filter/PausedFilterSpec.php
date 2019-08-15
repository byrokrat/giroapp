<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\PausedFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\Paused;
use PhpSpec\ObjectBehavior;

class PausedFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PausedFilter::class);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('paused');
    }

    function it_filters_donors(Donor $donor)
    {
        $donor->getState()->willReturn(new Paused);
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
