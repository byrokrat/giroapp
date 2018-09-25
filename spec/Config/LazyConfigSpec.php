<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\LazyConfig;
use byrokrat\giroapp\Config\ConfigInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LazyConfigSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(function () {
        });
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LazyConfig::CLASS);
    }

    function it_is_a_config()
    {
        $this->shouldHaveType(ConfigInterface::CLASS);
    }

    function it_contains_a_value()
    {
        $this->beConstructedWith(function () {
            return 'foobar';
        });
        $this->getValue()->shouldReturn('foobar');
    }
}
