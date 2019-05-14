<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\RollbackHandler;
use byrokrat\giroapp\CommandBus\Rollback;
use byrokrat\giroapp\Db\DriverInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RollbackHandlerSpec extends ObjectBehavior
{
    function let(DriverInterface $dbDriver)
    {
        $this->beConstructedWith($dbDriver);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RollbackHandler::CLASS);
    }

    function it_rollbacks_database($dbDriver)
    {
        $dbDriver->rollback()->shouldBeCalled();
        $this->handle(new Rollback);
    }
}
