<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\NewMandate;
use byrokrat\giroapp\Domain\State\ExportableStateInterface;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\MandateSent;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\autogiro\Writer\WriterInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewMandateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NewMandate::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('NEW_MANDATE');
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->shouldHaveType(ExportableStateInterface::CLASS);
    }

    function it_can_be_exported(Donor $donor, WriterInterface $writer, AccountNumber $account, IdInterface $id)
    {
        $donor->getPayerNumber()->willReturn('foobar');
        $donor->getAccount()->willReturn($account);
        $donor->getDonorId()->willReturn($id);
        $this->exportToAutogiro($donor, $writer)->shouldReturn(MandateSent::getStateId());
        $writer->addNewMandate('foobar', $account, $id)->shouldHaveBeenCalled();
    }
}
