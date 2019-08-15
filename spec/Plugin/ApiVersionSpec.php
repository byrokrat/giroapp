<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\ApiVersion;
use PhpSpec\ObjectBehavior;

class ApiVersionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ApiVersion::class);
    }

    function it_defaults_to_dev_master()
    {
        $this->getVersion()->shouldReturn('dev-master');
    }

    function it_contains_version()
    {
        $this->beConstructedWith('1.0.0');
        $this->getVersion()->shouldReturn('1.0.0');
    }

    function it_can_cast_to_string()
    {
        $this->beConstructedWith('1.0.0');
        $this->__toString()->shouldReturn('1.0.0');
    }

    function it_identifies_dev_versions()
    {
        $this->beConstructedWith('1.0.0-alpha4@a5e2cdd');
        $this->getVersion()->shouldReturn('1.0.0-dev');
    }

    function it_identifies_alpha_versions()
    {
        $this->beConstructedWith('1.0.0-alpha4');
        $this->getVersion()->shouldReturn('1.0.0-alpha4');
    }
}
