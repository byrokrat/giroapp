<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\LazyConfig;
use byrokrat\giroapp\Config\ConfigInterface;
use PhpSpec\ObjectBehavior;

class LazyConfigSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(function () {
        });
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LazyConfig::class);
    }

    function it_is_a_config()
    {
        $this->shouldHaveType(ConfigInterface::class);
    }

    function it_contains_a_value()
    {
        $this->beConstructedWith(function () {
            return 'foobar';
        });
        $this->getValue()->shouldReturn('foobar');
    }

    function it_fails_on_no_string_value()
    {
        $this->beConstructedWith(function () {
            return 123;
        });
        $this->shouldThrow(\LogicException::class)->during('getValue');
    }
}
