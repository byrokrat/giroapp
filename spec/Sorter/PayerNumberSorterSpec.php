<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\PayerNumberSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PayerNumberSorterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PayerNumberSorter::CLASS);
    }

    function it_is_a_sorter()
    {
        $this->shouldHaveType(SorterInterface::CLASS);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldReturn('payer-number');
    }

    function it_sorts_donors(Donor $left, Donor $right)
    {
        $left->getPayerNumber()->willReturn('A');
        $right->getPayerNumber()->willReturn('B');

        $this->compareDonors($left, $right)->shouldReturn(-1);
    }
}
