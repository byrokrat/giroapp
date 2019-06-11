<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain;

use byrokrat\giroapp\Domain\DonorCollection;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Sorter\SorterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorCollectionSpec extends ObjectBehavior
{
    function let(Donor $donorA, Donor $donorB)
    {
        $this->beConstructedWith([$donorA, $donorB]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorCollection::CLASS);
    }

    function it_throws_on_invalid_argument()
    {
        $this->beConstructedWith('this-is-not-callable-or-iterable');
        $this->shouldThrow(\InvalidArgumentException::CLASS)->duringInstantiation();
    }

    function it_is_iterable($donorA, $donorB)
    {
        $this->getIterator()->shouldIterateAs([$donorA, $donorB]);
    }

    function it_is_filterable($donorA, $donorB, FilterInterface $filter)
    {
        $filter->filterDonor($donorA)->willReturn(true);
        $filter->filterDonor($donorB)->willReturn(false);
        $this->filter($filter)->shouldIterateAs([$donorA]);
    }

    function it_can_chain_filters($donorA, $donorB, FilterInterface $filterA, FilterInterface $filterB)
    {
        $filterA->filterDonor($donorA)->willReturn(true);
        $filterA->filterDonor($donorB)->willReturn(false);
        $filterB->filterDonor($donorA)->willReturn(false);
        $this->filter($filterA)->filter($filterB)->shouldIterateAs([]);
    }

    function it_can_sort($donorA, $donorB, SorterInterface $sorter)
    {
        $sorter->compareDonors($donorA, $donorB)->willReturn(1);
        $this->sort($sorter)->shouldIterateAs([$donorB, $donorA]);
    }
}
