<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State;
use PhpSpec\ObjectBehavior;

class StateFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(State\StateFactory::CLASS);
    }

    function it_creates_states()
    {
        $this->createState(State\ActiveState::CLASS)->shouldHaveType(State\ActiveState::CLASS);
    }

    function it_fails_on_unknown_state_id()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringCreateState('not-a-valid-state-identifier');
    }

    function it_fails_on_wrong_id()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringCreateState(__CLASS__);
    }
}
