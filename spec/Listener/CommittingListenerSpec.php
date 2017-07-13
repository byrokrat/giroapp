<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\CommittingListener;
use hanneskod\yaysondb\Yaysondb;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommittingListenerSpec extends ObjectBehavior
{
    function let(Yaysondb $db)
    {
        $this->beConstructedWith($db);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommittingListener::CLASS);
    }

    function it_commits_database($db)
    {
        $db->commit()->shouldBeCalled();
        $this->__invoke();
    }
}
