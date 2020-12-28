<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\HumanDumper;
use byrokrat\giroapp\Xml\XmlMandateDumperInterface;
use byrokrat\giroapp\Xml\XmlMandate;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use Money\Money;
use Money\MoneyFormatter;
use PhpSpec\ObjectBehavior;

class HumanDumperSpec extends ObjectBehavior
{
    function let(MoneyFormatter $moneyFormatter)
    {
        $this->beConstructedWith($moneyFormatter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HumanDumper::class);
    }

    function it_is_a_dumper()
    {
        $this->shouldHaveType(XmlMandateDumperInterface::class);
    }

    function it_dumps($moneyFormatter, AccountNumber $account, IdInterface $id)
    {
        $mandate = new XmlMandate();

        $account->prettyprint()->willReturn('')->shouldBeCalled();
        $id->format('CS-sk')->willReturn('')->shouldBeCalled();

        $mandate->account = $account->getWrappedObject();
        $mandate->donorId = $id->getWrappedObject();

        $money = Money::SEK('100');
        $moneyFormatter->format($money)->willReturn('')->shouldBeCalled();
        $mandate->donationAmount = $money;

        $mandate->attributes['foo'] = 'bar';

        $this->dump($mandate)->shouldContain('attribute.foo');
    }
}
