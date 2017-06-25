<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\TransactionMapper;
use hanneskod\yaysondb\CollectionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection)
    {
        $this->beConstructedWith($collection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TransactionMapper::CLASS);
    }
}
