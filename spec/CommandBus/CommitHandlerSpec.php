<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\CommitHandler;
use byrokrat\giroapp\CommandBus\Commit;
use byrokrat\giroapp\Db\DriverInterface;
use byrokrat\giroapp\Event\ChangesCommitted;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommitHandlerSpec extends ObjectBehavior
{
    function let(DriverInterface $dbDriver, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($dbDriver);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommitHandler::class);
    }

    function it_dispatches_on_database_commit($dbDriver, $dispatcher)
    {
        $dbDriver->commit()->willReturn(true)->shouldBeCalled();
        $dispatcher->dispatch(new ChangesCommitted())->shouldBeCalled();
        $this->handle(new Commit());
    }

    function it_does_not_dispatch_on_no_commit($dbDriver, $dispatcher)
    {
        $dbDriver->commit()->willReturn(false)->shouldBeCalled();
        $dispatcher->dispatch(Argument::any())->shouldNotBeCalled();
        $this->handle(new Commit());
    }
}
