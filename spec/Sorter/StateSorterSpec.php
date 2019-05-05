<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\StateSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\State\StateInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateSorterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StateSorter::CLASS);
    }

    function it_is_a_sorter()
    {
        $this->shouldHaveType(SorterInterface::CLASS);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldReturn('state');
    }

    function it_sorts_donors(Donor $left, Donor $right, StateInterface $stateLeft, StateInterface $stateRight)
    {
        $left->getState()->willReturn($stateLeft);
        $right->getState()->willReturn($stateRight);

        $stateLeft->getStateId()->willReturn('A');
        $stateRight->getStateId()->willReturn('B');

        $this->compareDonors($left, $right)->shouldReturn(-1);
    }
}
