<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model\DonorState;

use byrokrat\giroapp\Model\DonorState;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\Writer;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MandateApprovedStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DonorState\MandateApprovedState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(DonorState\DonorState::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getId()->shouldEqual(DonorState\MandateApprovedState::CLASS);
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->isExportable()->shouldBe(true);
    }

    function it_does_not_export_without_an_amount(Donor $donor, Writer $writer, SEK $amount)
    {
        $amount->isPositive()->willReturn(false);

        $donor->getDonationAmount()->willReturn($amount);
        $donor->setState(Argument::type(DonorState\ActiveState::CLASS))->shouldNotBeCalled();

        $this->export($donor, $writer);
    }

    function it_can_be_exported(Donor $donor, Writer $writer, SEK $amount)
    {
        $amount->isPositive()->willReturn(true);

        $donor->getDonationAmount()->willReturn($amount);
        $donor->getPayerNumber()->willReturn('foobar');

        $donor->setState(Argument::type(DonorState\ActiveState::CLASS))->shouldBeCalled();

        $this->export($donor, $writer);

        $writer->addMonthlyTransaction('foobar', $amount, Argument::type('DateTime'), '')->shouldHaveBeenCalled();
    }
}
