<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\CreatedSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreatedSorterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CreatedSorter::CLASS);
    }

    function it_is_a_sorter()
    {
        $this->shouldHaveType(SorterInterface::CLASS);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldReturn('created');
    }

    function it_equals_donors(Donor $left, Donor $right)
    {
        $left->getCreated()->willReturn(new \DateTimeImmutable('2018-01-01'));
        $right->getCreated()->willReturn(new \DateTimeImmutable('2019-01-01'));
        $this->compareDonors($left, $right)->shouldReturn(-31536000);
    }
}
