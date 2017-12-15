<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\OutputtingListener;
use byrokrat\giroapp\Event\LogEvent;
use Symfony\Component\Console\Output\OutputInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OutputtingListenerSpec extends ObjectBehavior
{
    function let(OutputInterface $stdout, OutputInterface $errout)
    {
        $this->beConstructedWith($stdout, $errout);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OutputtingListener::CLASS);
    }

    function it_writes_error_messages(LogEvent $event, $errout)
    {
        $event->getMessage()->willReturn('foobar');
        $this->onError($event);
        $errout->writeln('<error>ERROR: foobar</error>')->shouldHaveBeenCalled();
    }

    function it_writes_warning_messages(LogEvent $event, $errout)
    {
        $event->getMessage()->willReturn('foobar');
        $this->onWarning($event);
        $errout->writeln('<question>WARNING: foobar</question>')->shouldHaveBeenCalled();
    }

    function it_writes_info_messages(LogEvent $event, $stdout)
    {
        $event->getMessage()->willReturn('foobar');
        $this->onInfo($event);
        $stdout->writeln('foobar')->shouldHaveBeenCalled();
    }

    function it_writes_debug_message_if_output_is_verbose(LogEvent $event, $stdout)
    {
        $event->getMessage()->willReturn('foobar');

        $stdout->isVerbose()->willReturn(true);
        $stdout->writeln('foobar')->shouldBeCalled();

        $this->onDebug($event);
    }

    function it_discards_debug_message_if_output_is_not_verbose(LogEvent $event, $stdout)
    {
        $event->getMessage()->willReturn('foobar');

        $stdout->isVerbose()->willReturn(false);
        $stdout->writeln('foobar')->shouldNotBeCalled();

        $this->onDebug($event);
    }
}
