<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp;

use byrokrat\giroapp\Donor;
use byrokrat\giroapp\State\State;
use byrokrat\autogiro\Writer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorSpec extends ObjectBehavior
{
    function let(State $state)
    {
        $this->beConstructedWith(
            $state,
            Donor::MANDATE_SOURCE_PAPER
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Donor::CLASS);
    }

    function it_contains_state($state)
    {
        $this->getState()->shouldEqual($state);
    }

    function it_can_change_state(State $newState)
    {
        $this->getState()->shouldNotEqual($newState);
        $this->setState($newState);
        $this->getState()->shouldEqual($newState);
    }

    function it_contains_mandate_source()
    {
        $this->getMandateSource()->shouldEqual(Donor::MANDATE_SOURCE_PAPER);
    }

    function it_is_exportable_to_autogiro($state, Writer $writer)
    {
        $this->exportToAutogiro($writer);
        $state->export($this->getWrappedObject(), $writer)->shouldHaveBeenCalled();
    }
}
