<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\RevokeMandateState;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\WriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RevokeMandateStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RevokeMandateState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual(States::REVOKE_MANDATE);
    }

    function it_contains_next_id()
    {
        $this->getNextStateId()->shouldEqual(States::REVOCATION_SENT);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->shouldBeExportable();
    }

    function it_can_be_exported(Donor $donor, WriterInterface $writer)
    {
        $donor->getPayerNumber()->willReturn('foobar');
        $this->export($donor, $writer);
        $writer->deleteMandate('foobar')->shouldHaveBeenCalled();
    }
}
