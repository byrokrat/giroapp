<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\StateSorter;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\StateInterface;
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

    function it_sorts_donors(Donor $left, Donor $right)
    {
        $left->getState()->willReturn(new class() implements StateInterface {
            public static function getStateId(): string
            {
                return 'A';
            }

            public function getDescription(): string
            {
            }
        });

        $right->getState()->willReturn(new class() implements StateInterface {
            public static function getStateId(): string
            {
                return 'B';
            }

            public function getDescription(): string
            {
            }
        });

        $this->compareDonors($left, $right)->shouldReturn(-1);
    }
}
