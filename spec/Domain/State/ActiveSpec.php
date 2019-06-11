<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\Active;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ActiveSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Active::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('ACTIVE');
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }
}
