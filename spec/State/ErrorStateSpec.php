<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\ErrorState;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\WriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ErrorState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual(States::ERROR);
    }

    function it_contains_next_id()
    {
        $this->getNextStateId()->shouldEqual(States::ERROR);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_not_exportable()
    {
        $this->shouldNotBeExportable();
    }

    function it_can_be_exported(Donor $donor, WriterInterface $writer)
    {
        $this->export($donor, $writer);
    }

    function it_is_not_active()
    {
        $this->shouldNotBeActive();
    }

    function it_is_not_awaiting_response()
    {
        $this->shouldNotBeAwaitingResponse();
    }

    function it_is_error()
    {
        $this->shouldBeError();
    }

    function it_is_not_purgeable()
    {
        $this->shouldNotBePurgeable();
    }
}
