<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model\DonorState;

use byrokrat\giroapp\Model\DonorState;
use byrokrat\giroapp\Model\Donor;
use byrokrat\autogiro\Writer\Writer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ErrorStateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DonorState\ErrorState::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(DonorState\StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getId()->shouldEqual(DonorState\ErrorState::CLASS);
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
