<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Status;

use byrokrat\giroapp\Status\StatisticsManager;
use byrokrat\giroapp\Status\StatisticInterface;
use byrokrat\giroapp\Exception\InvalidStatisticException;
use PhpSpec\ObjectBehavior;

class StatisticsManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StatisticsManager::class);
    }

    function it_throws_if_statistic_is_not_set()
    {
        $this->shouldThrow(InvalidStatisticException::class)->duringGetStatistic('does-not-exist');
    }

    function it_can_get_statistic(StatisticInterface $statistic)
    {
        $statistic->getName()->willReturn('foo');
        $this->addStatistic($statistic);
        $this->getStatistic('foo')->shouldReturn($statistic);
    }

    function it_can_get_all_statistic(StatisticInterface $statistic)
    {
        $statistic->getName()->willReturn('foo');
        $this->addStatistic($statistic);
        $this->getAllStatistics()->shouldReturn(['foo' => $statistic]);
    }
}
