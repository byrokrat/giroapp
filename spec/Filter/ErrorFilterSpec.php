<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\ErrorFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\Error;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ErrorFilter::CLASS);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::CLASS);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('error');
    }

    function it_filters_donors(Donor $donor)
    {
        $donor->getState()->willReturn(new Error);
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
