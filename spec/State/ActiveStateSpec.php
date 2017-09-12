<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\ActiveState;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\Writer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ActiveStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ActiveState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getId()->shouldEqual(States::ACTIVE);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_not_exportable()
    {
        $this->isExportable()->shouldBe(false);
    }

    function it_can_be_exported(Donor $donor, Writer $writer)
    {
        $this->export($donor, $writer);
    }
}