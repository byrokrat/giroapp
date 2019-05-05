<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\NewMandateState;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\WriterInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewMandateStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NewMandateState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual(States::NEW_MANDATE);
    }

    function it_contains_next_id()
    {
        $this->getNextStateId()->shouldEqual(States::MANDATE_SENT);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->shouldBeExportable();
    }

    function it_can_be_exported(Donor $donor, WriterInterface $writer, AccountNumber $account, IdInterface $id)
    {
        $donor->getPayerNumber()->willReturn('foobar');
        $donor->getAccount()->willReturn($account);
        $donor->getDonorId()->willReturn($id);
        $this->export($donor, $writer);
        $writer->addNewMandate('foobar', $account, $id)->shouldHaveBeenCalled();
    }

    function it_is_not_active()
    {
        $this->shouldNotBeActive();
    }

    function it_is_not_awaiting_response()
    {
        $this->shouldNotBeAwaitingResponse();
    }

    function it_is_not_error()
    {
        $this->shouldNotBeError();
    }

    function it_is_not_purgeable()
    {
        $this->shouldNotBePurgeable();
    }

    function it_is_not_paused()
    {
        $this->shouldNotBePaused();
    }
}
