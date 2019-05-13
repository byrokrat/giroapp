<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\CommittingListener;
use byrokrat\giroapp\Db\DriverInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommittingListenerSpec extends ObjectBehavior
{
    function let(DriverInterface $dbDriver)
    {
        $this->beConstructedWith($dbDriver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommittingListener::CLASS);
    }

    function it_commits_database($dbDriver)
    {
        $dbDriver->commit()->shouldBeCalled();
        $this->onExecutionStoped();
    }
}
