<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Builder;

use byrokrat\giroapp\Builder\DateBuilder;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DateBuilderSpec extends ObjectBehavior
{
    function let(SystemClock $systemClock, ConfigInterface $dayOfMonth, ConfigInterface $minDaysInFuture)
    {
        $this->beConstructedWith($systemClock, $dayOfMonth, $minDaysInFuture);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DateBuilder::CLASS);
    }

    function it_finds_date_in_current_month($systemClock, $dayOfMonth)
    {
        $dayOfMonth->getValue()->willReturn(26);
        $systemClock->getNow()->willReturn(new \DateTimeImmutable('2017-07-07'));
        $this->buildDate()->shouldBeLike(new \DateTimeImmutable('2017-07-26'));
    }

    function it_finds_date_in_next_month($systemClock, $dayOfMonth)
    {
        $dayOfMonth->getValue()->willReturn(28);
        $systemClock->getNow()->willReturn(new \DateTimeImmutable('2017-07-30'));
        $this->buildDate()->shouldBeLike(new \DateTimeImmutable('2017-08-28'));
    }

    function it_finds_date_in_next_year($systemClock, $dayOfMonth)
    {
        $dayOfMonth->getValue()->willReturn(28);
        $systemClock->getNow()->willReturn(new \DateTimeImmutable('2017-12-30'));
        $this->buildDate()->shouldBeLike(new \DateTimeImmutable('2018-01-28'));
    }

    function it_finds_date_in_next_month_if_day_not_x_days_in_future($systemClock, $dayOfMonth, $minDaysInFuture)
    {
        $dayOfMonth->getValue()->willReturn(28);
        $minDaysInFuture->getValue()->willReturn(5);
        $systemClock->getNow()->willReturn(new \DateTimeImmutable('2017-07-24'));
        $this->buildDate()->shouldBeLike(new \DateTimeImmutable('2017-08-28'));
    }
}
