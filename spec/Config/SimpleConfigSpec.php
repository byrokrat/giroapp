<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\SimpleConfig;
use byrokrat\giroapp\Config\ConfigInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SimpleConfigSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SimpleConfig::CLASS);
    }

    function it_is_a_config()
    {
        $this->shouldHaveType(ConfigInterface::CLASS);
    }

    function it_contains_a_value()
    {
        $this->beConstructedWith('foobar');
        $this->getValue()->shouldReturn('foobar');
    }
}
