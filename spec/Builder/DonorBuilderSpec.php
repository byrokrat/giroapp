<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Builder;

use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Builder\MandateKeyBuilder;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\DonorState\NewMandateState;
use byrokrat\giroapp\Model\DonorState\NewDigitalMandateState;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\id\Id;
use byrokrat\banking\AccountNumber;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorBuilderSpec extends ObjectBehavior
{
    const MANDATE_KEY = 'mandate-key';

    const PAYER_NUMBER = 'payer-number';

    function let(MandateKeyBuilder $keyBuilder, Id $id, AccountNumber $account)
    {
        $id->format('Ssk')->willReturn(self::PAYER_NUMBER);
        $keyBuilder->buildKey($id, $account)->willReturn(self::MANDATE_KEY);
        $this->beConstructedWith($keyBuilder);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorBuilder::CLASS);
    }

    function it_fails_if_id_is_not_set($account)
    {
        $this->setAccount($account)
            ->setName('name');

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_fails_if_account_is_not_set($id)
    {
        $this->setId($id)
            ->setName('name');

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_fails_if_name_is_not_set($id, $account)
    {
        $this->setId($id)
            ->setAccount($account);

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_fails_if_unvalid_mandate_source_is_set($id, $account)
    {
        $this->setId($id)
            ->setAccount($account)
            ->setMandateSource('this-is-not-a-valid-mandate-source');

        $this->shouldThrow(\RuntimeException::CLASS)->during('buildDonor');
    }

    function it_builds_minimal_donors($id, $account)
    {
        $this->setId($id)->setAccount($account)->setName('name')->buildDonor()->shouldHaveType(Donor::CLASS);
    }

    function it_uses_default_values($id, $account)
    {
        $this->setId($id)->setAccount($account)->setName('name')->buildDonor()->shouldBeLike(new Donor(
            self::MANDATE_KEY,
            new NewMandateState,
            Donor::MANDATE_SOURCE_PAPER,
            self::PAYER_NUMBER,
            $account->getWrappedObject(),
            $id->getWrappedObject(),
            'name',
            new PostalAddress('', '', '', '', ''),
            '',
            '',
            new SEK('0'),
            ''
        ));
    }

    function it_can_set_values($id, $account, PostalAddress $postalAddress, SEK $amount)
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
            ->buildDonor();

        $createdDonor->shouldBeLike(
            new Donor(
                self::MANDATE_KEY,
                new NewDigitalMandateState,
                Donor::MANDATE_SOURCE_DIGITAL,
                'payer-number',
                $account->getWrappedObject(),
                $id->getWrappedObject(),
                'name',
                $postalAddress->getWrappedObject(),
                'email',
                'phone',
                $amount->getWrappedObject(),
                'comment'
            )
        );
    }
}
