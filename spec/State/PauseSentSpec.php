<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\PauseSent;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\AwaitingResponseStateInterface;
use byrokrat\giroapp\Model\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PauseSentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PauseSent::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
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
        $this->shouldHaveType(AwaitingResponseStateInterface::CLASS);
    }
}
