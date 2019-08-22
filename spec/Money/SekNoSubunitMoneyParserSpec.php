<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Money;

use byrokrat\giroapp\Money\SekNoSubunitMoneyParser;
use Money\Money;
use Money\MoneyParser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SekNoSubunitMoneyParserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SekNoSubunitMoneyParser::CLASS);
    }

    function it_is_a_money_parser()
    {
        $this->shouldHaveType(MoneyParser::CLASS);
    }

    function it_fails_on_non_string()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringParse(null);
    }

    function it_fails_on_invalid_chars()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringParse('foo');
    }

    function it_creates_regular_money()
    {
        $this->parse('1')->shouldReturnAmount('100');
    }

    function it_trims_leading_zeros()
    {
        $this->parse('001')->shouldReturnAmount('100');
    }

    function it_defaults_to_zero()
    {
        $this->parse('0000')->shouldReturnAmount('0');
    }

    function it_sets_zero_on_empty_string()
    {
        $this->parse('')->shouldReturnAmount('0');
    }

    function it_creates_negative_money()
    {
        $this->parse('-1')->shouldReturnAmount('-100');
    }

    function it_trims_zeros_on_negative_money()
    {
        $this->parse('-001')->shouldReturnAmount('-100');
    }

    function it_handles_decimals()
    {
        $this->parse('1.00')->shouldReturnAmount('1');
    }

    function it_handles_decimals_and_left_trims_negative_amounts()
    {
        $this->parse('-01.00')->shouldReturnAmount('-1');
    }

    public function getMatchers(): array
    {
        return [
            'returnAmount' => function (Money $money, string $expected) {
                if (strcmp($money->getAmount(), $expected) != 0) {
                    throw new \Exception("Raw money {$money->getAmount()} does not equal $expected");
                }

                return true;
            },
        ];
    }
}
