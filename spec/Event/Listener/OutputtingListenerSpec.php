<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\Listener\OutputtingListener;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
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
        $this->shouldHaveType(OutputtingListener::class);
    }

    function it_writes_error_messages(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::ERROR);
        $this->__invoke($event);
        $output->writeln('<error>ERROR: foobar</error>')->shouldHaveBeenCalled();
    }

    function it_writes_warning_messages(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::WARNING);
        $this->__invoke($event);
        $output->writeln('<question>WARNING: foobar</question>')->shouldHaveBeenCalled();
    }

    function it_writes_info_messages(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::INFO);
        $this->__invoke($event);
        $output->writeln('foobar')->shouldHaveBeenCalled();
    }

    function it_writes_debug_message_if_output_is_verbose(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::DEBUG);

        $output->isVerbose()->willReturn(true);
        $output->writeln('foobar')->shouldBeCalled();

        $this->__invoke($event);
    }

    function it_discards_debug_message_if_output_is_not_verbose(LogEvent $event, $output)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::DEBUG);

        $output->isVerbose()->willReturn(false);
        $output->writeln(Argument::any())->shouldNotBeCalled();

        $this->__invoke($event);
    }
}
