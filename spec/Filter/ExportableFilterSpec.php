<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Filter;

use byrokrat\giroapp\Filter\ExportableFilter;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\ExportableStateInterface;
use byrokrat\giroapp\Domain\State\StateInterface;
use PhpSpec\ObjectBehavior;

class ExportableFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExportableFilter::class);
    }

    function it_is_a_filter()
    {
        $this->shouldHaveType(FilterInterface::class);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn('exportable');
    }

    function it_filters_donors(Donor $donor, StateInterface $state)
    {
        $donor->getState()->willReturn($state);
        $state->implement(ExportableStateInterface::class);
        $this->filterDonor($donor)->shouldReturn(true);
    }
}
