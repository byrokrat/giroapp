<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\UpdatedSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;

class UpdatedSorterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UpdatedSorter::class);
    }

    function it_is_a_sorter()
    {
        $this->shouldHaveType(SorterInterface::class);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldReturn('updated');
    }

    function it_equals_donors(Donor $left, Donor $right)
    {
        $left->getUpdated()->willReturn(new \DateTimeImmutable('2018-01-01'));
        $right->getUpdated()->willReturn(new \DateTimeImmutable('2019-01-01'));
        $this->compareDonors($left, $right)->shouldReturn(-31536000);
    }
}
