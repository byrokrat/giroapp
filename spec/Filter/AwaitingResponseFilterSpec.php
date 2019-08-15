<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\AwaitingResponseFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\AwaitingResponseStateInterface;
use byrokrat\giroapp\Domain\State\StateInterface;
use PhpSpec\ObjectBehavior;

class AwaitingResponseFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AwaitingResponseFilter::class);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('awaiting');
    }

    function it_filters_donors(Donor $donor, AwaitingResponseStateInterface $state)
    {
        $donor->getState()->willReturn($state);
        $state->implement(StateInterface::class);
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
