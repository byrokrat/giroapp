<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\NewDonorProcessor;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\NewDonor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\MandateSources;
use byrokrat\giroapp\State\NewMandate;
use byrokrat\giroapp\State\NewDigitalMandate;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\amount\Currency\SEK;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewDonorProcessorSpec extends ObjectBehavior
{
    function let(
        StateCollection $stateCollection,
        SystemClock $systemClock,
        StateInterface $state,
        NewDonor $newDonor,
        PostalAddress $address,
        IdInterface $id,
        AccountNumber $account
    ) {
        $this->beConstructedWith($stateCollection, $systemClock);
        $systemClock->getNow()->willReturn(new \DateTimeImmutable);
        $stateCollection->getState(Argument::any())->willReturn($state);
        $state->getDescription()->willReturn('');
        $id->format('Ss')->willReturn('1');
        $account->get16()->willReturn('11');
        $newDonor->getPostalAddress()->willReturn($address);
        $newDonor->getDonorId()->willReturn($id);
        $newDonor->getAccount()->willReturn($account);
        $newDonor->getMandateSource()->willReturn(MandateSources::MANDATE_SOURCE_PAPER);
        $newDonor->getPayerNumber()->willReturn('');
        $newDonor->getName()->willReturn('');
        $newDonor->getEmail()->willReturn('');
        $newDonor->getPhone()->willReturn('');
        $newDonor->getDonationAmount()->willReturn(new SEK('1'));
        $newDonor->getComment()->willReturn('');
        $newDonor->getAttributes()->willReturn([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NewDonorProcessor::CLASS);
    }

    function it_processes_new_donor(
        $stateCollection,
        $systemClock,
        $state,
        PostalAddress $address,
        IdInterface $id,
        AccountNumber $account
    ) {
        $now = new \DateTimeImmutable;
        $systemClock->getNow()->willReturn($now);

        $stateCollection->getState(NewMandate::CLASS)->willReturn($state);

        $amount = new SEK('1');

        $id->format('Ss')->willReturn('1');
        $account->get16()->willReturn('11');

        $this->processNewDonor(new NewDonor(
            MandateSources::MANDATE_SOURCE_PAPER,
            'payer-number',
            $account->getWrappedObject(),
            $id->getWrappedObject(),
            'name',
            $address->getWrappedObject(),
            'mail',
            'phone',
            $amount,
            'comment',
            ['attributes']
        ))->shouldBeLike(new Donor(
            'pPy7LDdwRb1YKXAx',
            $state->getWrappedObject(),
            MandateSources::MANDATE_SOURCE_PAPER,
            'payer-number',
            $account->getWrappedObject(),
            $id->getWrappedObject(),
            'name',
            $address->getWrappedObject(),
            'mail',
            'phone',
            $amount,
            'comment',
            $now,
            $now,
            ['attributes']
        ));
    }

    function it_sets_new_state_on_source_paper($stateCollection, $state, $newDonor)
    {
        $newDonor->getMandateSource()->willReturn(MandateSources::MANDATE_SOURCE_PAPER);
        $stateCollection->getState(NewMandate::CLASS)->shouldBeCalled()->willReturn($state);
        $this->processNewDonor($newDonor);
    }

    function it_sets_new_state_on_source_online($stateCollection, $state, $newDonor)
    {
        $newDonor->getMandateSource()->willReturn(MandateSources::MANDATE_SOURCE_ONLINE_FORM);
        $stateCollection->getState(NewMandate::CLASS)->shouldBeCalled()->willReturn($state);
        $this->processNewDonor($newDonor);
    }

    function it_sets_new_digital_on_source_digital($stateCollection, $state, $newDonor)
    {
        $newDonor->getMandateSource()->willReturn(MandateSources::MANDATE_SOURCE_DIGITAL);
        $stateCollection->getState(NewDigitalMandate::CLASS)->shouldBeCalled()->willReturn($state);
        $this->processNewDonor($newDonor);
    }

    function it_throws_if_mandate_source_is_invalid($newDonor)
    {
        $newDonor->getMandateSource()->willReturn('not-a-valid-mandate-source');
        $this->shouldThrow(\LogicException::CLASS)->duringProcessNewDonor($newDonor);
    }

    function it_creates_keys_for_short_input($newDonor, $id, $account)
    {
        $id->format('Ss')->shouldBeCalled()->willReturn('1');
        $account->get16()->shouldBeCalled()->willReturn('11');
        $this->processNewDonor($newDonor)->shouldHaveType(Donor::CLASS);
    }

    function it_creates_keys_for_long_input($newDonor, $id, $account)
    {
        $id->format('Ss')->shouldBeCalled()->willReturn('999999999');
        $account->get16()->shouldBeCalled()->willReturn('9999999999999999');
        $this->processNewDonor($newDonor)->shouldHaveType(Donor::CLASS);
    }

    function it_throws_if_key_could_not_be_created($newDonor, $id, $account)
    {
        $id->format('Ss')->willReturn('');
        $account->get16()->willReturn('');
        $this->shouldThrow(\LogicException::CLASS)->duringProcessNewDonor($newDonor);
    }
}
