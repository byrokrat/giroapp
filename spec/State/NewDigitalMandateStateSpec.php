<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State;
use byrokrat\giroapp\Donor;
use byrokrat\autogiro\Writer\Writer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewDigitalMandateStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(State\NewDigitalMandateState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(State\State::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getId()->shouldEqual(State\NewDigitalMandateState::CLASS);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable_to_autogiro(Donor $donor, Writer $writer)
    {
        $this->isExportable()->shouldBe(true);

        $this->export($donor, $writer);

        $donor->setState(Argument::type(State\MandateSentState::CLASS))->shouldHaveBeenCalled();
    }
}
