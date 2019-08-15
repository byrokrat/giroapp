<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\PauseSent;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\AwaitingResponseStateInterface;
use PhpSpec\ObjectBehavior;

class PauseSentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PauseSent::class);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::class);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('PAUSE_SENT');
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_awaiting_response()
    {
        $this->shouldHaveType(AwaitingResponseStateInterface::class);
    }
}
