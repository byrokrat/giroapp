<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DriverEnvironment;
use byrokrat\giroapp\Domain\DonorFactory;
use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DriverEnvironmentSpec extends ObjectBehavior
{
    function let(SystemClock $clock, DonorFactory $donorFactory)
    {
        $this->beConstructedWith($clock, $donorFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DriverEnvironment::CLASS);
    }

    function it_contains_a_clock($clock)
    {
        $this->getClock()->shouldReturn($clock);
    }

    function it_contains_a_donor_factory($donorFactory)
    {
        $this->getDonorFactory()->shouldReturn($donorFactory);
    }
}
