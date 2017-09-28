<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\banking\AccountNumber;
use byrokrat\id\PersonalId;
use byrokrat\amount\Currency\SEK;
use byrokrat\autogiro\Writer\Writer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorSpec extends ObjectBehavior
{
    const MANDATE_KEY = 'mandate-key';
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
        SEK $donationAmount
    ) {
        $this->beConstructedWith(
            self::MANDATE_KEY,
            $state,
            Donor::MANDATE_SOURCE_PAPER,
            self::PAYER_NUMBER,
            $account,
            $donorId,
            self::NAME,
            $address,
            self::EMAIL,
            self::PHONE,
            $donationAmount,
            self::COMMENT,
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

    function it_can_set_state(StateInterface $newState)
    {
        $this->getState()->shouldNotEqual($newState);
        $this->setState($newState);
        $this->getState()->shouldEqual($newState);
    }

    function it_contains_mandate_source()
    {
        $this->getMandateSource()->shouldEqual(Donor::MANDATE_SOURCE_PAPER);
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
        $this->getAddress()->shouldEqual($address);
    }

    function it_can_set_address(PostalAddress $newAddress)
    {
        $this->getAddress()->shouldNotEqual($newAddress);
        $this->setAddress($newAddress);
        $this->getAddress()->shouldEqual($newAddress);
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

    function it_is_exportable_to_autogiro($state, Writer $writer)
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
