<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\DescendingSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DescendingSorterSpec extends ObjectBehavior
{
    function let(SorterInterface $wrapped)
    {
        $this->beConstructedWith($wrapped);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DescendingSorter::CLASS);
    }

    function it_is_a_sorter()
    {
        $this->shouldHaveType(SorterInterface::CLASS);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldReturn('');
    }

    function it_sorts_donors($wrapped, Donor $left, Donor $right)
    {
        $wrapped->compareDonors($left, $right)->willReturn(1);
        $this->compareDonors($left, $right)->shouldReturn(-1);
    }
}
