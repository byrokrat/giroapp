<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\NameSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;

class NameSorterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NameSorter::class);
    }

    function it_is_a_sorter()
    {
        $this->shouldHaveType(SorterInterface::class);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldReturn('name');
    }

    function it_equals_donors(Donor $left, Donor $right)
    {
        $left->getName()->willReturn('A');
        $right->getName()->willReturn('B');
        $this->compareDonors($left, $right)->shouldReturn(-1);
    }
}
