<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\DonationAmountFromAttributePass;
use byrokrat\giroapp\Xml\XmlMandate;
use PhpSpec\ObjectBehavior;
use Money\Money;
use Money\Currency;
use Money\MoneyParser;

class DonationAmountFromAttributePassSpec extends ObjectBehavior
{
    function let(MoneyParser $moneyParser)
    {
        $this->beConstructedWith('attr-key', $moneyParser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonationAmountFromAttributePass::class);
    }

    function it_ignore_unknown_attr()
    {
        $input = new XmlMandate();
        $this->processMandate($input)->shouldBeLike($input);
    }

    function it_sets_value_from_attr($moneyParser)
    {
        $input = new XmlMandate();
        $input->attributes['attr-key'] = 'foobar';

        $money = Money::SEK('100');

        $moneyParser->parse('foobar', new Currency('SEK'))->willReturn($money);

        $expected = clone $input;
        $expected->donationAmount = $money;

        $this->processMandate($input)->shouldBeLike($expected);
    }
}
