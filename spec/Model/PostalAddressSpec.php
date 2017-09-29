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
}
