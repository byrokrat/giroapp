<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\Paused;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\Model\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PausedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Paused::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('PAUSED');
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }
}
