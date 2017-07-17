<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\PostalAddress;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostalAddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('', '', '', '', '');
        $this->shouldHaveType(PostalAddress::CLASS);
    }

    function it_contains_co_address()
    {
        $this->beConstructedWith('', '', '', '', 'foobar');
        $this->getCoAddress()->shouldEqual('foobar');
    }

    function it_contains_address_line_1()
    {
        $this->beConstructedWith('', '', 'foobar', '', '');
        $this->getAddress1()->shouldEqual('foobar');
    }

    function it_contains_address_line_2()
    {
        $this->beConstructedWith('', '', '', 'foobar', '');
        $this->getAddress2()->shouldEqual('foobar');
    }

    function it_contains_a_postal_code()
    {
        $this->beConstructedWith('foobar', '', '', '', '');
        $this->getPostalCode()->shouldEqual('foobar');
    }

    function it_contains_a_postal_city()
    {
        $this->beConstructedWith('', 'foobar', '', '', '');
        $this->getPostalCity()->shouldEqual('foobar');
    }
}
