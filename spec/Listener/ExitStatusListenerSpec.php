<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\ExitStatusListener;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExitStatusListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExitStatusListener::CLASS);
    }

    function it_defaults_to_status_zero()
    {
        $this->getExitStatus()->shouldReturn(0);
    }

    function it_returns_non_zero_on_failure()
    {
        $this->onFailure();
        $this->getExitStatus()->shouldNotReturn(0);
    }
}
