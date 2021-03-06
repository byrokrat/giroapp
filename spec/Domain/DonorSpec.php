<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Domain;

use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Exception\UnknownIdentifierException;
use byrokrat\banking\AccountNumber;
use byrokrat\id\PersonalId;
use Money\Money;
use PhpSpec\ObjectBehavior;

class DonorSpec extends ObjectBehavior
{
    public const MANDATE_KEY = 'mandate-key';
    public const PAYER_NUMBER = 'payer-number';
    public const NAME = 'name';
    public const EMAIL = 'email';
    public const PHONE = 'phone';
    public const COMMENT = 'comment';
    public const ATTR_KEY = 'ATTR_KEY';
    public const ATTR_VALUE = 'ATTR_VALUE';
    public const DONATION_AMOUNT = 100;

    function let(
        StateInterface $state,
        AccountNumber $account,
        PersonalId $donorId,
        PostalAddress $address,
        \DateTimeImmutable $created,
        \DateTimeImmutable $updated
    ) {
        $this->beConstructedWith(
            self::MANDATE_KEY,
            $state,
            MandateSources::MANDATE_SOURCE_PAPER,
            self::PAYER_NUMBER,
            $account,
            $donorId,
            self::NAME,
            $address,
            self::EMAIL,
            self::PHONE,
            Money::SEK(self::DONATION_AMOUNT),
            self::COMMENT,
            $created,
            $updated,
            [self::ATTR_KEY => self::ATTR_VALUE]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Donor::class);
    }

    function it_contains_a_mandate_key()
    {
        $this->getMandateKey()->shouldEqual(self::MANDATE_KEY);
    }

    function it_contains_a_state($state)
    {
        $this->getState()->shouldEqual($state);
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

    function it_contains_an_amount()
    {
        $this->getDonationAmount()->shouldBeLike(Money::SEK(self::DONATION_AMOUNT));
    }

    function it_contains_a_comment()
    {
        $this->getComment()->shouldEqual(self::COMMENT);
    }

    function it_contains_a_created_date($created)
    {
        $this->getCreated()->shouldEqual($created);
    }

    function it_contains_an_updated_date($updated)
    {
        $this->getUpdated()->shouldEqual($updated);
    }

    function it_contains_attributes()
    {
        $this->getAttribute(self::ATTR_KEY)->shouldReturn(self::ATTR_VALUE);
    }

    function it_can_check_for_attribute()
    {
        $this->hasAttribute('does-not-exist')->shouldReturn(false);
        $this->hasAttribute(self::ATTR_KEY)->shouldReturn(true);
    }

    function it_throws_exception_if_attribute_does_not_exist()
    {
        $this->shouldThrow(UnknownIdentifierException::class)->duringGetAttribute('foobar');
    }

    function it_can_show_all_attributes()
    {
        $this->getAttributes()->shouldReturn([self::ATTR_KEY => self::ATTR_VALUE]);
    }
}
