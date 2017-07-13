<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Mapper\Arrayizer\DonorArrayizer;
use hanneskod\yaysondb\CollectionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection, DonorArrayizer $donorArrayizer)
    {
        $this->beConstructedWith($collection, $donorArrayizer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorMapper::CLASS);
    }
}
