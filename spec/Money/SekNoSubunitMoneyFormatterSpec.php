<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Money;

use byrokrat\giroapp\Money\SekNoSubunitMoneyFormatter;
use Money\Money;
use Money\MoneyFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SekNoSubunitMoneyFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SekNoSubunitMoneyFormatter::CLASS);
    }

    function it_is_a_money_formatter()
    {
        $this->shouldHaveType(MoneyFormatter::CLASS);
    }

    function it_fails_on_non_sek_money()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFormat(Money::EUR(100));
    }

    function it_formats_with_no_subunit()
    {
        $this->format(Money::SEK(100))->shouldReturn('1');
    }

    function it_formats_negative_amounts_with_no_subunit()
    {
        $this->format(Money::SEK(-100))->shouldReturn('-1');
    }

    function it_formats_zero()
    {
        $this->format(Money::SEK(0))->shouldReturn('0');
    }

    function it_fails_if_there_are_subunits()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFormat(Money::SEK(123));
    }
}
