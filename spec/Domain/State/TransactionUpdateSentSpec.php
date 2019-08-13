<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\TransactionUpdateSent;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\AwaitingResponseStateInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TransactionUpdateSentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TransactionUpdateSent::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('TRANSACTION_UPDATE_SENT');
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
