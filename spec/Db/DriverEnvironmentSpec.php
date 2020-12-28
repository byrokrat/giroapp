<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DriverEnvironment;
use byrokrat\giroapp\Domain\DonorFactory;
use byrokrat\giroapp\Utils\SystemClock;
use Money\MoneyFormatter;
use PhpSpec\ObjectBehavior;

class DriverEnvironmentSpec extends ObjectBehavior
{
    function let(SystemClock $clock, DonorFactory $donorFactory, MoneyFormatter $moneyFormatter)
    {
        $this->beConstructedWith($clock, $donorFactory, $moneyFormatter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DriverEnvironment::class);
    }

    function it_contains_a_clock($clock)
    {
        $this->getClock()->shouldReturn($clock);
    }

    function it_contains_a_donor_factory($donorFactory)
    {
        $this->getDonorFactory()->shouldReturn($donorFactory);
    }

    function it_contains_a_money_formatter($moneyFormatter)
    {
        $this->getMoneyFormatter()->shouldReturn($moneyFormatter);
    }
}
