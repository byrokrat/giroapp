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
        $db->inTransaction()->willReturn(true);
        $db->commit()->shouldBeCalled();
        $this->__invoke();
    }

    function it_does_not_commit_if_not_in_transaction($db)
    {
        $db->inTransaction()->willReturn(false);
        $db->commit()->shouldNotBeCalled();
        $this->__invoke();
    }
}
