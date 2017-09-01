<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model\DonorState;

use byrokrat\giroapp\Model\DonorState;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\Writer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RevokeMandateStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DonorState\RevokeMandateState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(DonorState\StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getId()->shouldEqual(DonorState\RevokeMandateState::CLASS);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->isExportable()->shouldBe(true);
    }

    function it_can_be_exported(Donor $donor, Writer $writer)
    {
        $donor->getPayerNumber()->willReturn('foobar');
        $donor->setState(Argument::type(DonorState\RevocationSentState::CLASS))->shouldBeCalled();

        $this->export($donor, $writer);

        $writer->deleteMandate('foobar')->shouldHaveBeenCalled();
    }
}
