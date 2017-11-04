<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\StatePool;
use byrokrat\giroapp\State\ActiveState;
use byrokrat\giroapp\State\ErrorState;
use byrokrat\giroapp\State\InactiveState;
use byrokrat\giroapp\State\NewMandateState;
use byrokrat\giroapp\State\NewDigitalMandateState;
use byrokrat\giroapp\State\MandateSentState;
use byrokrat\giroapp\State\MandateApprovedState;
use byrokrat\giroapp\State\RevokeMandateState;
use byrokrat\giroapp\State\RevocationSentState;
use byrokrat\giroapp\States;
use PhpSpec\ObjectBehavior;

class StatePoolSpec extends ObjectBehavior
{
    function let(
        ActiveState $active,
        ErrorState $error,
        InactiveState $inactive,
        NewMandateState $newMandate,
        NewDigitalMandateState $newDigitalMandate,
        MandateSentState $mandateSent,
        MandateApprovedState $mandateApproved,
        RevokeMandateState $revokeMandate,
        RevocationSentState $revocationSent
    ) {
        $this->beConstructedWith(
            $active,
            $error,
            $inactive,
            $newMandate,
            $newDigitalMandate,
            $mandateSent,
            $mandateApproved,
            $revokeMandate,
            $revocationSent
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StatePool::CLASS);
    }

    function it_fails_on_unknown_state()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringGetState('not-a-valid-state-identifier');
    }

    function it_creates_active_state($active)
    {
        $this->getState(States::ACTIVE)->shouldReturn($active);
    }

    function it_is_case_insensitive($error)
    {
        $this->getState(strtolower(States::ERROR))->shouldReturn($error);
    }

    function it_creates_error_state($error)
    {
        $this->getState(States::ERROR)->shouldReturn($error);
    }

    function it_creates_inactive_state($inactive)
    {
        $this->getState(States::INACTIVE)->shouldReturn($inactive);
    }

    function it_creates_new_mandate_state($newMandate)
    {
        $this->getState(States::NEW_MANDATE)->shouldReturn($newMandate);
    }

    function it_creates_new_digital_mandate_state($newDigitalMandate)
    {
        $this->getState(States::NEW_DIGITAL_MANDATE)->shouldReturn($newDigitalMandate);
    }

    function it_creates_mandate_sent_state($mandateSent)
    {
        $this->getState(States::MANDATE_SENT)->shouldReturn($mandateSent);
    }

    function it_creates_mandate_approved_state($mandateApproved)
    {
        $this->getState(States::MANDATE_APPROVED)->shouldReturn($mandateApproved);
    }

    function it_creates_revoke_mandate_state($revokeMandate)
    {
        $this->getState(States::REVOKE_MANDATE)->shouldReturn($revokeMandate);
    }

    function it_creates_revocation_sent_state($revocationSent)
    {
        $this->getState(States::REVOCATION_SENT)->shouldReturn($revocationSent);
    }
}
