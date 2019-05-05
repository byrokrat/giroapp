<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\NewDonor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\MandateSources;
use byrokrat\banking\AccountNumber;
use byrokrat\id\PersonalId;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NewDonorSpec extends ObjectBehavior
{
    const PAYER_NUMBER = 'payer-number';
    const NAME = 'name';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const COMMENT = 'comment';
    const ATTR_KEY = 'ATTR_KEY';
    const ATTR_VALUE = 'ATTR_VALUE';

    function let(AccountNumber $account, PersonalId $donorId, PostalAddress $address, SEK $donationAmount)
    {
        $this->beConstructedWith(
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
            [self::ATTR_KEY => self::ATTR_VALUE]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NewDonor::CLASS);
    }

    function it_contains_mandate_source()
    {
        $this->getMandateSource()->shouldEqual(MandateSources::MANDATE_SOURCE_PAPER);
    }

    function it_contains_a_payer_number()
    {
        $this->getPayerNumber()->shouldEqual(self::PAYER_NUMBER);
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

    function it_contains_an_address($address)
    {
        $this->getPostalAddress()->shouldEqual($address);
    }

    function it_contains_an_email()
    {
        $this->getEmail()->shouldEqual(self::EMAIL);
    }

    function it_contains_a_phone_number()
    {
        $this->getPhone()->shouldEqual(self::PHONE);
    }

    function it_contains_an_amount($donationAmount)
    {
        $this->getDonationAmount()->shouldEqual($donationAmount);
    }

    function it_contains_a_comment()
    {
        $this->getComment()->shouldEqual(self::COMMENT);
    }

    function it_can_show_all_attributes()
    {
        $this->getAttributes()->shouldReturn([self::ATTR_KEY => self::ATTR_VALUE]);
    }
}
