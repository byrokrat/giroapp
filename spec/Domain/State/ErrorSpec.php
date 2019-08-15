<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\Error;
use byrokrat\giroapp\Domain\State\StateInterface;
use PhpSpec\ObjectBehavior;

class ErrorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Error::class);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::class);
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
