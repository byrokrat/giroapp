<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\StateFactory;
use byrokrat\giroapp\State\ActiveState;
use byrokrat\giroapp\States;
use PhpSpec\ObjectBehavior;

class StateFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StateFactory::CLASS);
    }

    function it_creates_states()
    {
        $this->createState(ActiveState::CLASS)->shouldHaveType(ActiveState::CLASS);
    }

    function it_fails_on_unknown_state_id()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringCreateState('not-a-valid-state-identifier');
    }

    function it_fails_on_wrong_id()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringCreateState(__CLASS__);
    }

    function it_creates_states_from_state_id()
    {
        $this->createState(States::ACTIVE)->shouldHaveType(ActiveState::CLASS);
    }
}
