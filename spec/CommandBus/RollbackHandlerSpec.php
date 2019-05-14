<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\RollbackHandler;
use byrokrat\giroapp\CommandBus\Rollback;
use byrokrat\giroapp\Db\DriverInterface;
use byrokrat\giroapp\Event\ChangesDiscarded;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RollbackHandlerSpec extends ObjectBehavior
{
    function let(DriverInterface $dbDriver, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dbDriver);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RollbackHandler::CLASS);
    }

    function it_dispatches_on_database_rollback($dbDriver, $dispatcher)
    {
        $dbDriver->rollback()->willReturn(true)->shouldBeCalled();
        $dispatcher->dispatch(ChangesDiscarded::CLASS, new ChangesDiscarded)->shouldBeCalled();
        $this->handle(new Rollback);
    }

    function it_does_not_dispatch_on_no_rollback($dbDriver, $dispatcher)
    {
        $dbDriver->rollback()->willReturn(false)->shouldBeCalled();
        $dispatcher->dispatch(Argument::any())->shouldNotBeCalled();
        $this->handle(new Rollback);
    }
}
