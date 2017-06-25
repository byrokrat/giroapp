<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model\DonorState;

use byrokrat\giroapp\Model\DonorState;
use PhpSpec\ObjectBehavior;

class StateFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DonorState\DonorStateFactory::CLASS);
    }

    function it_creates_states()
    {
        $this->createDonorState(DonorState\ActiveState::CLASS)->shouldHaveType(DonorState\ActiveState::CLASS);
    }

    function it_fails_on_unknown_state_id()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringCreateDonorState('not-a-valid-state-identifier');
    }

    function it_fails_on_wrong_id()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringCreateDonorState(__CLASS__);
    }
}
