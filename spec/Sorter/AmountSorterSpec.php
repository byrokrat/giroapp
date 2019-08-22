<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\AmountSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Domain\Donor;
use Money\Money;
use PhpSpec\ObjectBehavior;

class AmountSorterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AmountSorter::class);
    }

    function it_is_a_sorter()
    {
        $this->shouldHaveType(SorterInterface::class);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldReturn('amount');
    }

    function it_equals_donors(Donor $left, Donor $right)
    {
        $left->getDonationAmount()->willReturn(Money::SEK('1'));
        $right->getDonationAmount()->willReturn(Money::SEK('2'));
        $this->compareDonors($left, $right)->shouldReturn(-1);
    }
}
