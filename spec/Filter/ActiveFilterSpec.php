<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\ActiveFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\Active;
use PhpSpec\ObjectBehavior;

class ActiveFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ActiveFilter::class);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('active');
    }

    function it_filters_donors(Donor $donor)
    {
        $donor->getState()->willReturn(new Active());
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
