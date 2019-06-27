<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\NewDigitalMandate;
use byrokrat\giroapp\Domain\State\ExportableStateInterface;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\MandateSent;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\autogiro\Writer\WriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewDigitalMandateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NewDigitalMandate::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('NEW_DIGITAL_MANDATE');
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->shouldHaveType(ExportableStateInterface::CLASS);
    }

    function it_can_be_exported(Donor $donor, WriterInterface $writer)
    {
        $donor->getPayerNumber()->willReturn('foobar');
        $this->exportToAutogiro($donor, $writer)->shouldReturn(MandateSent::getStateId());
        $writer->acceptDigitalMandate('foobar')->shouldHaveBeenCalled();
    }
}
