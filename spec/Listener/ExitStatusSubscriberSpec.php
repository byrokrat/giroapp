<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\ExitStatusSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExitStatusSubscriberSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ExitStatusSubscriber::CLASS);
    }

    function it_is_a_subsriber()
    {
        $this->shouldHaveType(EventSubscriberInterface::CLASS);
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
