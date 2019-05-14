<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\CommittingListener;
use byrokrat\giroapp\CommandBus\Commit;
use League\Tactician\CommandBus;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommittingListenerSpec extends ObjectBehavior
{
    function let(CommandBus $commandBus)
    {
        $this->setCommandBus($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommittingListener::CLASS);
    }

    function it_commits_database($commandBus)
    {
        $commandBus->handle(new Commit)->shouldBeCalled();
        $this->onExecutionStoped();
    }
}
