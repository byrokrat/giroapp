<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp;

use byrokrat\giroapp\Version;
use PhpSpec\ObjectBehavior;

class VersionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Version::class);
    }

    function it_contains_version()
    {
        $this->getVersion()->shouldBeString();
    }
}
