<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\Error;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\Model\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Error::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('ERROR');
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }
}
