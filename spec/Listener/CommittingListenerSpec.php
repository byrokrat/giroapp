<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\CommittingListener;
use byrokrat\giroapp\Db\DriverInterface;
use hanneskod\yaysondb\Yaysondb;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommittingListenerSpec extends ObjectBehavior
{
    function let(Yaysondb $db, DriverInterface $dbDriver)
    {
        $this->beConstructedWith($db, $dbDriver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommittingListener::CLASS);
    }

    function it_commits_database($db, $dbDriver)
    {
        $db->commit()->shouldBeCalled();
        $dbDriver->commit()->shouldBeCalled();
        $this->onExecutionStoped();
    }
}
