<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\RevokedFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\Revoked;
use PhpSpec\ObjectBehavior;

class RevokedFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RevokedFilter::class);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('revoked');
    }

    function it_filters_donors(Donor $donor)
    {
        $donor->getState()->willReturn(new Revoked);
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
