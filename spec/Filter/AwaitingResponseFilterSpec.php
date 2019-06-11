<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\AwaitingResponseFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\AwaitingResponseStateInterface;
use byrokrat\giroapp\Domain\State\StateInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AwaitingResponseFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AwaitingResponseFilter::CLASS);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::CLASS);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('awaiting');
    }

    function it_filters_donors(Donor $donor, AwaitingResponseStateInterface $state)
    {
        $donor->getState()->willReturn($state);
        $state->implement(StateInterface::CLASS);
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
