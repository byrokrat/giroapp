<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Builder;

use byrokrat\giroapp\Builder\DateBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DateBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DateBuilder::CLASS);
    }

    function it_finds_date_in_current_month()
    {
        $this->setCurrentDate(new \DateTime('2017-07-07'))
            ->setDayOfMonth(28)
            ->buildDate()
            ->shouldBeLike(new \DateTime('2017-07-28'));
    }

    function it_finds_date_in_next_month()
    {
        $this->setCurrentDate(new \DateTime('2017-07-30'))
            ->setDayOfMonth(28)
            ->buildDate()
            ->shouldBeLike(new \DateTime('2017-08-28'));
    }

    function it_finds_date_in_next_year()
    {
        $this->setCurrentDate(new \DateTime('2017-12-30'))
            ->setDayOfMonth(28)
            ->buildDate()
            ->shouldBeLike(new \DateTime('2018-01-28'));
    }

    function it_finds_date_in_next_month_if_day_not_x_days_in_future()
    {
        $this->setCurrentDate(new \DateTime('2017-07-24'))
            ->setDayOfMonth(28)
            ->setMinDaysInFuture(5)
            ->buildDate()
            ->shouldBeLike(new \DateTime('2017-08-28'));
    }
}
