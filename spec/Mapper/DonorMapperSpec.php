<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\DonorMapper;
use hanneskod\yaysondb\CollectionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection)
    {
        $this->beConstructedWith($collection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorMapper::CLASS);
    }
}
