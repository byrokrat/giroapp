<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Builder;

use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Builder\MandateKeyBuilder;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\StatePool;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\id\IdInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorBuilderSpec extends ObjectBehavior
{
    const MANDATE_KEY = 'mandate-key';

    const PAYER_NUMBER = 'payer-number';

    function let(
        MandateKeyBuilder $keyBuilder,
        IdInterface $id,
        AccountNumber $account,
        StatePool $statePool,
        StateInterface $state,
        SystemClock $systemClock,
        \DateTime $datetime
    ) {
        $id->format('Ssk')->willReturn(self::PAYER_NUMBER);
        $keyBuilder->buildKey($id, $account)->willReturn(self::MANDATE_KEY);
        $statePool->getState(Argument::any())->willReturn($state);
        $systemClock->getNow()->willReturn($datetime);
        $this->beConstructedWith($keyBuilder, $statePool, $systemClock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorBuilder::CLASS);
    }

    function it_fails_if_id_is_not_set($account)
    {
        $this->setAccount($account)
            ->setMandateSource(Donor::MANDATE_SOURCE_PAPER)
            ->setName('name');

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_fails_if_account_is_not_set($id)
    {
        $this->setId($id)
            ->setMandateSource(Donor::MANDATE_SOURCE_PAPER)
            ->setName('name');

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_fails_if_name_is_not_set($id, $account)
    {
        $this->setId($id)
            ->setMandateSource(Donor::MANDATE_SOURCE_PAPER)
            ->setAccount($account);

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_fails_if_unvalid_mandate_source_is_set($id, $account)
    {
        $this->setId($id)
            ->setAccount($account)
            ->setName('name')
            ->setMandateSource('this-is-not-a-valid-mandate-source');

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_fails_if_mandate_source_is_not_set($id, $account)
    {
        $this->setId($id)
            ->setAccount($account)
            ->setName('name');

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_builds_minimal_donors($id, $account)
    {
        $this->setId($id)
            ->setAccount($account)
            ->setName('name')
            ->setMandateSource(Donor::MANDATE_SOURCE_PAPER)
            ->buildDonor()
            ->shouldHaveType(Donor::CLASS);
    }

    function it_can_reset($id, $account)
    {
        $this->setId($id)
            ->setAccount($account)
            ->setName('name')
            ->setMandateSource(Donor::MANDATE_SOURCE_PAPER)
            ->reset();

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_uses_default_values($id, $account, $statePool, $state, $datetime)
    {
        $statePool->getState(States::NEW_MANDATE)->shouldBeCalled()->willReturn($state);
        $this->setId($id)
            ->setAccount($account)
            ->setName('name')
            ->setMandateSource(Donor::MANDATE_SOURCE_PAPER)
            ->buildDonor()
            ->shouldBeLike(
                new Donor(
                    self::MANDATE_KEY,
                    $state->getWrappedObject(),
                    'Mandate created',
                    Donor::MANDATE_SOURCE_PAPER,
                    self::PAYER_NUMBER,
                    $account->getWrappedObject(),
                    $id->getWrappedObject(),
                    'name',
                    new PostalAddress('', '', '', '', ''),
                    '',
                    '',
                    new SEK('0'),
                    '',
                    $datetime->getWrappedObject(),
                    $datetime->getWrappedObject()
                )
            );
    }

    function it_can_set_values($id, $account, PostalAddress $postalAddress, SEK $amount, $statePool, $state, $datetime)
    {
        $createdDonor = $this->setId($id)
            ->setAccount($account)
            ->setName('name')
            ->setMandateSource(Donor::MANDATE_SOURCE_DIGITAL)
            ->setPayerNumber('payer-number')
            ->setPostalAddress($postalAddress)
            ->setEmail('email')
            ->setPhone('phone')
            ->setDonationAmount($amount)
            ->setComment('comment')
            ->setAttribute('foo', 'bar')
            ->setAttribute('baz', 'bal')
            ->buildDonor();

        $statePool->getState(States::NEW_DIGITAL_MANDATE)->shouldBeCalled()->willReturn($state);

        $createdDonor->shouldBeLike(
            new Donor(
                self::MANDATE_KEY,
                $state->getWrappedObject(),
                'Mandate created',
                Donor::MANDATE_SOURCE_DIGITAL,
                'payer-number',
                $account->getWrappedObject(),
                $id->getWrappedObject(),
                'name',
                $postalAddress->getWrappedObject(),
                'email',
                'phone',
                $amount->getWrappedObject(),
                'comment',
                $datetime->getWrappedObject(),
                $datetime->getWrappedObject(),
                [
                    'foo' => 'bar',
                    'baz' => 'bal'
                ]
            )
        );
    }
}
