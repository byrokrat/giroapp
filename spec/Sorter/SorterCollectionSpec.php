<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Sorter\SorterCollection;
use byrokrat\giroapp\Sorter\SorterInterface;
use PhpSpec\ObjectBehavior;

class SorterCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SorterCollection::class);
    }

    function it_contains_sorter(SorterInterface $sorter)
    {
        $sorter->getName()->willReturn('foobar');
        $this->addSorter($sorter);
        $this->getSorter('foobar')->shouldReturn($sorter);
    }

    function it_can_get_sorter_names(SorterInterface $sorter)
    {
        $sorter->getName()->willReturn('foobar');
        $this->addSorter($sorter);
        $this->getItemKeys()->shouldContain('foobar');
    }
}
