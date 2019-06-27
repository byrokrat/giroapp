<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\RevokeMandate;
use byrokrat\giroapp\Domain\State\ExportableStateInterface;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\RevocationSent;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\autogiro\Writer\WriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RevokeMandateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RevokeMandate::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('REVOKE_MANDATE');
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
        $this->exportToAutogiro($donor, $writer)->shouldReturn(RevocationSent::getStateId());
        $writer->deleteMandate('foobar')->shouldHaveBeenCalled();
    }
}
