<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SystemClockSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SystemClock::CLASS);
    }

    function it_creates_now()
    {
        $this->getNow()->shouldHaveType(\DateTimeInterface::CLASS);
    }
}
