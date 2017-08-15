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
    function let(OutputInterface $output)
    {
        $this->beConstructedWith($output);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OutputtingListener::CLASS);
    }

    function it_writes_error_messages(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $this->onErrorEvent($event);
        $output->writeln('<error>ERROR: foobar</error>')->shouldHaveBeenCalled();
    }

    function it_writes_warning_messages(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $this->onWarningEvent($event);
        $output->writeln('<question>WARNING: foobar</question>')->shouldHaveBeenCalled();
    }

    function it_writes_info_messages(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $this->onInfoEvent($event);
        $output->writeln('foobar')->shouldHaveBeenCalled();
    }

    function it_writes_debug_message_if_output_is_verbose(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');

        $output->isVerbose()->willReturn(true);
        $output->writeln('foobar')->shouldBeCalled();

        $this->onDebugEvent($event);
    }

    function it_discards_debug_message_if_output_is_not_verbose(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');

        $output->isVerbose()->willReturn(false);
        $output->writeln('foobar')->shouldNotBeCalled();

        $this->onDebugEvent($event);
    }
}
