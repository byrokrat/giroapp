<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\MandateApproved;
use byrokrat\giroapp\Domain\State\Active;
use byrokrat\giroapp\Domain\State\ExportableStateInterface;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\TransactionDateFactory;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\autogiro\Writer\WriterInterface;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MandateApprovedSpec extends ObjectBehavior
{
    function let(TransactionDateFactory $dateFactory)
    {
        $this->beConstructedWith($dateFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MandateApproved::CLASS);
    }

    function it_implements_the_state_interface()
    {
        $this->shouldHaveType(StateInterface::CLASS);
    }

    function it_contains_an_id()
    {
        $this->getStateId()->shouldEqual('MANDATE_APPROVED');
    }

    function it_contains_a_description()
    {
        $this->getDescription()->shouldBeString();
    }

    function it_is_exportable()
    {
        $this->shouldHaveType(ExportableStateInterface::CLASS);
    }

    function it_does_not_export_without_an_amount(Donor $donor, WriterInterface $writer, SEK $amount)
    {
        $amount->isPositive()->willReturn(false);
        $donor->getDonationAmount()->willReturn($amount);
        $writer->addMonthlyPayment(Argument::cetera())->shouldNotBeCalled();
        $this->exportToAutogiro($donor, $writer);
    }

    function it_can_be_exported($dateFactory, Donor $donor, WriterInterface $writer, SEK $amount)
    {
        $amount->isPositive()->willReturn(true);

        $donor->getDonationAmount()->willReturn($amount);
        $donor->getPayerNumber()->willReturn('payer_number');
        $donor->getMandateKey()->willReturn('mandate_key');

        $date = new \DateTimeImmutable;
        $dateFactory->createNextTransactionDate()->willReturn($date);

        $this->exportToAutogiro($donor, $writer)->shouldReturn(Active::getStateId());

        $writer->addMonthlyPayment('payer_number', $amount, $date, 'mandate_key')->shouldHaveBeenCalled();
    }
}
