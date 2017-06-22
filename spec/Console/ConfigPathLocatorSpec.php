<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Console;

use byrokrat\giroapp\Console\ConfigPathLocator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigPathLocatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ConfigPathLocator::CLASS);
    }

    function it_returns_option_if_specified()
    {
        $this->locateConfigPath('option', 'environment')->shouldBeLike('option');
    }

    function it_returns_environment_if_option_is_missing()
    {
        $this->locateConfigPath('', 'environment')->shouldBeLike('environment');
    }

    function it_returns_default_path_if_nothins_is_specified()
    {
        $this->locateConfigPath('', '')->shouldMatch('/\.giroapp$/');
    }
}
