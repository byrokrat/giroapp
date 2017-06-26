<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\DI;

use byrokrat\giroapp\DI\UserDirectoryLocator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserDirectoryLocatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserDirectoryLocator::CLASS);
    }

    function it_returns_option_if_specified()
    {
        $this->locateUserDirectory('option', 'environment')->shouldBeLike('option');
    }

    function it_returns_environment_if_option_is_missing()
    {
        $this->locateUserDirectory('', 'environment')->shouldBeLike('environment');
    }

    function it_returns_default_path_if_nothins_is_specified()
    {
        $this->locateUserDirectory('', '')->shouldMatch('/\.giroapp$/');
    }
}
