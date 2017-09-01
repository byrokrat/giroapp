<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\State;

use byrokrat\giroapp\State\NewMandateState;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\MandateSentState;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\Writer;
use byrokrat\banking\AccountNumber;
use byrokrat\id\Id;
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
        $this->getId()->shouldEqual(NewMandateState::CLASS);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->isExportable()->shouldBe(true);
    }

    function it_can_be_exported(Donor $donor, Writer $writer, AccountNumber $account, Id $id)
    {
        $donor->getPayerNumber()->willReturn('foobar');
        $donor->getAccount()->willReturn($account);
        $donor->getDonorId()->willReturn($id);

        $donor->setState(Argument::type(MandateSentState::CLASS))->shouldBeCalled();

        $this->export($donor, $writer);

        $writer->addNewMandate('foobar', $account, $id)->shouldHaveBeenCalled();
    }
}
