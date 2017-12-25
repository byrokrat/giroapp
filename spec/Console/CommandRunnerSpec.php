<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Console;

use byrokrat\giroapp\Console\CommandRunner;
use byrokrat\giroapp\Console\CommandInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Listener\ExitStatusListener;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandRunnerSpec extends ObjectBehavior
{
    function let(Dispatcher $dispatcher, ExitStatusListener $exitStatusListener)
    {
        $this->beConstructedWith($dispatcher, $exitStatusListener);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CommandRunner::CLASS);
    }

    function it_runs_commands($dispatcher, $exitStatusListener, CommandInterface $command)
    {
        $dispatcher->dispatch(Events::EXECUTION_STARTED, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $command->execute()->shouldBeCalled();
        $dispatcher->dispatch(Events::EXECUTION_STOPED, Argument::type(LogEvent::CLASS))->shouldBeCalled();

        $exitStatusListener->getExitStatus()->willReturn(999);

        $this->run($command)->shouldReturn(999);
    }

    function it_dispatches_error_on_exception($dispatcher, $exitStatusListener, CommandInterface $command)
    {
        $dispatcher->dispatch(Events::EXECUTION_STARTED, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $command->execute()->willThrow(\Exception::CLASS);
        $dispatcher->dispatch(Events::ERROR, Argument::type(LogEvent::CLASS))->shouldBeCalled();

        $exitStatusListener->getExitStatus()->willReturn(999);

        $this->run($command)->shouldReturn(999);
    }
}
