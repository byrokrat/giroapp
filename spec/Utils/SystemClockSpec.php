<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;

class SystemClockSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SystemClock::class);
    }

    function it_creates_now()
    {
        $this->getNow()->shouldHaveType(\DateTimeImmutable::class);
    }
}
