<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\OutputtingSubscriber;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OutputtingSubscriberSpec extends ObjectBehavior
{
    function let(OutputInterface $errout)
    {
        $this->beConstructedWith($errout);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OutputtingSubscriber::CLASS);
    }

    function it_is_a_subsriber()
    {
        $this->shouldHaveType(EventSubscriberInterface::CLASS);
    }

    function it_writes_error_messages(LogEvent $event, $errout)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::ERROR);
        $this->onLogEvent($event);
        $errout->writeln('<error>ERROR: foobar</error>')->shouldHaveBeenCalled();
    }

    function it_writes_warning_messages(LogEvent $event, $errout)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::WARNING);
        $this->onLogEvent($event);
        $errout->writeln('<question>WARNING: foobar</question>')->shouldHaveBeenCalled();
    }

    function it_writes_info_messages(LogEvent $event, $errout)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::INFO);
        $this->onLogEvent($event);
        $errout->writeln('foobar')->shouldHaveBeenCalled();
    }

    function it_writes_debug_message_if_output_is_verbose(LogEvent $event, $errout)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::DEBUG);

        $errout->isVerbose()->willReturn(true);
        $errout->writeln('foobar')->shouldBeCalled();

        $this->onLogEvent($event);
    }

    function it_discards_debug_message_if_output_is_not_verbose(LogEvent $event, $errout)
    {
        $event->getMessage()->willReturn('foobar');
        $event->getSeverity()->willReturn(LogLevel::DEBUG);

        $errout->isVerbose()->willReturn(false);
        $errout->writeln(Argument::any())->shouldNotBeCalled();

        $this->onLogEvent($event);
    }
}
