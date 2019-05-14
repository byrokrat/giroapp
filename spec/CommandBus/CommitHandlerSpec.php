<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\CommitHandler;
use byrokrat\giroapp\CommandBus\Commit;
use byrokrat\giroapp\Db\DriverInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommitHandlerSpec extends ObjectBehavior
{
    function let(DriverInterface $dbDriver)
    {
        $this->beConstructedWith($dbDriver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommitHandler::CLASS);
    }

    function it_commits_database($dbDriver)
    {
        $dbDriver->commit()->shouldBeCalled();
        $this->handle(new Commit);
    }
}
