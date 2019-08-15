<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain;

use byrokrat\giroapp\Domain\PostalAddress;
use PhpSpec\ObjectBehavior;

class PostalAddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('', '', '', '', '');
        $this->shouldHaveType(PostalAddress::class);
    }

    function it_contains_line_1()
    {
        $this->beConstructedWith('foobar', '', '', '', '');
        $this->getLine1()->shouldEqual('foobar');
    }

    function it_contains_line_2()
    {
        $this->beConstructedWith('', 'foobar', '', '', '');
        $this->getLine2()->shouldEqual('foobar');
    }

    function it_contains_line_3()
    {
        $this->beConstructedWith('', '', 'foobar', '', '');
        $this->getLine3()->shouldEqual('foobar');
    }

    function it_contains_a_postal_code()
    {
        $this->beConstructedWith('', '', '', 'foobar', '');
        $this->getPostalCode()->shouldEqual('foobar');
    }

    function it_contains_a_postal_city()
    {
        $this->beConstructedWith('', '', '', '', 'foobar');
        $this->getPostalCity()->shouldEqual('foobar');
    }

    function it_can_be_converted_to_string()
    {
        $this->beConstructedWith('Street 1', '', '', '12345', 'city');
        $this->__toString()->shouldReturn("Street 1\n12345 city");
    }
}
