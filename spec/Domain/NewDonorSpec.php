<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain;

use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\banking\AccountNumber;
use byrokrat\id\PersonalId;
use Money\Money;
use PhpSpec\ObjectBehavior;

class NewDonorSpec extends ObjectBehavior
{
    const PAYER_NUMBER = 'payer-number';
    const DONATION_AMOUNT = 100;

    function let(AccountNumber $account, PersonalId $donorId)
    {
        $this->beConstructedWith(
            MandateSources::MANDATE_SOURCE_PAPER,
            self::PAYER_NUMBER,
            $account,
            $donorId,
            Money::SEK(self::DONATION_AMOUNT)
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NewDonor::class);
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

    function it_contains_an_amount()
    {
        $this->getDonationAmount()->shouldBeLike(Money::SEK(self::DONATION_AMOUNT));
    }
}
