<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\MandateSources;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\banking\AccountNumber;
use byrokrat\id\PersonalId;
use byrokrat\amount\Currency\SEK;
use byrokrat\autogiro\Writer\WriterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorSpec extends ObjectBehavior
{
    const MANDATE_KEY = 'mandate-key';
    const STATE_DESC = 'state-desc';
    const PAYER_NUMBER = 'payer-number';
    const NAME = 'name';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const COMMENT = 'comment';
    const ATTR_KEY = 'ATTR_KEY';
    const ATTR_VALUE = 'ATTR_VALUE';

    function let(
        StateInterface $state,
        AccountNumber $account,
        PersonalId $donorId,
        PostalAddress $address,
        SEK $donationAmount,
        \DateTimeImmutable $created,
        \DateTimeImmutable $updated
    ) {
        $this->beConstructedWith(
            self::MANDATE_KEY,
            $state,
            self::STATE_DESC,
            MandateSources::MANDATE_SOURCE_PAPER,
            self::PAYER_NUMBER,
            $account,
            $donorId,
            self::NAME,
            $address,
            self::EMAIL,
            self::PHONE,
            $donationAmount,
            self::COMMENT,
            $created,
            $updated,
            [self::ATTR_KEY => self::ATTR_VALUE]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Donor::CLASS);
    }

    function it_contains_a_mandate_key()
    {
        $this->getMandateKey()->shouldEqual(self::MANDATE_KEY);
    }

    function it_contains_a_state($state)
    {
        $this->getState()->shouldEqual($state);
    }

    function it_contains_a_state_desc()
    {
        $this->getStateDesc()->shouldEqual(self::STATE_DESC);
    }

    function it_can_set_state(StateInterface $newState)
    {
        $this->getState()->shouldNotEqual($newState);
        $this->setState($newState, 'desc');
        $this->getState()->shouldEqual($newState);
        $this->getStateDesc()->shouldEqual('desc');
    }

    function it_reads_default_state_descs(StateInterface $newState)
    {
        $newState->getDescription()->willReturn('foobar');
        $this->setState($newState);
        $this->getStateDesc()->shouldEqual('foobar');
    }

    function it_contains_mandate_source()
    {
        $this->getMandateSource()->shouldEqual(MandateSources::MANDATE_SOURCE_PAPER);
    }

    function it_contains_a_payer_number()
    {
        $this->getPayerNumber()->shouldEqual(self::PAYER_NUMBER);
    }

    function it_can_set_payer_number()
    {
        $payerNumber = 'some-new-payer-number';
        $this->setPayerNumber($payerNumber);
        $this->getPayerNumber()->shouldEqual($payerNumber);
    }

    function it_contains_an_account($account)
    {
        $this->getAccount()->shouldEqual($account);
    }

    function it_contains_a_donor_id($donorId)
    {
        $this->getDonorId()->shouldEqual($donorId);
    }

    function it_contains_a_name()
    {
        $this->getName()->shouldEqual(self::NAME);
    }

    function it_can_set_name()
    {
        $name = 'some-new-name';
        $this->setName($name);
        $this->getName()->shouldEqual($name);
    }

    function it_contains_an_address($address)
    {
        $this->getPostalAddress()->shouldEqual($address);
    }

    function it_can_set_address(PostalAddress $newAddress)
    {
        $this->getPostalAddress()->shouldNotEqual($newAddress);
        $this->setPostalAddress($newAddress);
        $this->getPostalAddress()->shouldEqual($newAddress);
    }

    function it_contains_an_email()
    {
        $this->getEmail()->shouldEqual(self::EMAIL);
    }

    function it_can_set_email()
    {
        $newEmail = 'this@that.tld';
        $this->setEmail($newEmail);
        $this->getEmail()->shouldEqual($newEmail);
    }

    function it_contains_a_phone_number()
    {
        $this->getPhone()->shouldEqual(self::PHONE);
    }

    function it_can_set_phone()
    {
        $newPhone = '+4670111111';
        $this->setPhone($newPhone);
        $this->getPhone()->shouldEqual($newPhone);
    }

    function it_contains_an_amount($donationAmount)
    {
        $this->getDonationAmount()->shouldEqual($donationAmount);
    }

    function it_can_set_amount(SEK $newAmount)
    {
        $this->getDonationAmount()->shouldNotEqual($newAmount);
        $this->setDonationAmount($newAmount);
        $this->getDonationAmount()->shouldEqual($newAmount);
    }

    function it_contains_a_comment()
    {
        $this->getComment()->shouldEqual(self::COMMENT);
    }

    function it_can_set_comment()
    {
        $newComment = 'some comment...';
        $this->setComment($newComment);
        $this->getComment()->shouldEqual($newComment);
    }

    function it_contains_a_created_date($created)
    {
        $this->getCreated()->shouldEqual($created);
    }

    function it_contains_an_updated_date($updated)
    {
        $this->getUpdated()->shouldEqual($updated);
    }

    function it_can_set_updated_date(\DateTimeImmutable $newUpdated)
    {
        $this->setUpdated($newUpdated);
        $this->getUpdated()->shouldEqual($newUpdated);
    }

    function it_is_exportable_to_autogiro($state, WriterInterface $writer)
    {
        $this->exportToAutogiro($writer);
        $state->export($this->getWrappedObject(), $writer)->shouldHaveBeenCalled();
    }

    function it_contains_attributes()
    {
        $this->getAttribute(self::ATTR_KEY)->shouldReturn(self::ATTR_VALUE);
    }

    function it_can_check_for_attribute()
    {
        $this->hasAttribute('foobar')->shouldReturn(false);
    }

    function it_recognizes_loaded_attributes()
    {
        $this->setAttribute('foobar', 'baz');
        $this->hasAttribute('foobar')->shouldReturn(true);
    }

    function it_can_read_attributes()
    {
        $this->setAttribute('foobar', 'baz');
        $this->getAttribute('foobar')->shouldReturn('baz');
    }

    function it_throws_exception_if_attribute_does_not_exist()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringGetAttribute('foobar');
    }

    function it_can_show_all_attributes()
    {
        $this->getAttributes()->shouldReturn([self::ATTR_KEY => self::ATTR_VALUE]);
    }
}
