<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Console;

use byrokrat\giroapp\Console\ImportTransactionManager;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Event\Listener\ErrorListener;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\CommandBus\Rollback;
use Symfony\Component\Console\Input\InputInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportTransactionManagerSpec extends ObjectBehavior
{
    function let(
        ConfigInterface $alwaysForceImportsConfig,
        ErrorListener $errorListener,
        CommandBusInterface $commandBus,
        EventDispatcherInterface $dispatcher
    ) {
        $this->beConstructedWith($alwaysForceImportsConfig, $errorListener);
        $this->setCommandBus($commandBus);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportTransactionManager::class);
    }

    function it_does_nothing_if_there_are_no_errors(
        InputInterface $input,
        $errorListener,
        $alwaysForceImportsConfig,
        $commandBus,
        $dispatcher
    ) {
        $errorListener->getErrors()->willReturn([]);
        $alwaysForceImportsConfig->getValue()->willReturn('');
        $input->getOption('force')->willReturn(false);
        $input->getOption('not-force')->willReturn(false);

        $commandBus->handle(Argument::type(Rollback::class))->shouldNotBeCalled();
        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldNotBeCalled();

        $this->manageTransaction($input);
    }

    function it_rolls_back_on_error(
        InputInterface $input,
        $errorListener,
        $alwaysForceImportsConfig,
        $commandBus,
        $dispatcher
    ) {
        $errorListener->getErrors()->willReturn(['ERROR']);
        $alwaysForceImportsConfig->getValue()->willReturn('');
        $input->getOption('force')->willReturn(false);
        $input->getOption('not-force')->willReturn(false);

        $commandBus->handle(Argument::type(Rollback::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldBeCalled();

        $this->manageTransaction($input);
    }

    function it_ignores_error_if_force_option_is_set(
        InputInterface $input,
        $errorListener,
        $alwaysForceImportsConfig,
        $commandBus,
        $dispatcher
    ) {
        $errorListener->getErrors()->willReturn(['ERROR']);
        $alwaysForceImportsConfig->getValue()->willReturn('');
        $input->getOption('force')->willReturn(true);
        $input->getOption('not-force')->willReturn(false);

        $commandBus->handle(Argument::type(Rollback::class))->shouldNotBeCalled();
        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldNotBeCalled();

        $this->manageTransaction($input);
    }

    function it_rolls_back_on_error_when_force_and_not_force_is_set(
        InputInterface $input,
        $errorListener,
        $alwaysForceImportsConfig,
        $commandBus,
        $dispatcher
    ) {
        $errorListener->getErrors()->willReturn(['ERROR']);
        $alwaysForceImportsConfig->getValue()->willReturn('');
        $input->getOption('force')->willReturn(true);
        $input->getOption('not-force')->willReturn(true);

        $commandBus->handle(Argument::type(Rollback::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldBeCalled();

        $this->manageTransaction($input);
    }

    function it_ignores_error_if_always_force_input_config_is_set(
        InputInterface $input,
        $errorListener,
        $alwaysForceImportsConfig,
        $commandBus,
        $dispatcher
    ) {
        $errorListener->getErrors()->willReturn(['ERROR']);
        $alwaysForceImportsConfig->getValue()->willReturn('1');
        $input->getOption('force')->willReturn(false);
        $input->getOption('not-force')->willReturn(false);

        $commandBus->handle(Argument::type(Rollback::class))->shouldNotBeCalled();
        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldNotBeCalled();

        $this->manageTransaction($input);
    }

    function it_rolls_back_on_error_when_always_force_input_and_not_force_is_set(
        InputInterface $input,
        $errorListener,
        $alwaysForceImportsConfig,
        $commandBus,
        $dispatcher
    ) {
        $errorListener->getErrors()->willReturn(['ERROR']);
        $alwaysForceImportsConfig->getValue()->willReturn('1');
        $input->getOption('force')->willReturn(false);
        $input->getOption('not-force')->willReturn(true);

        $commandBus->handle(Argument::type(Rollback::class))->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldBeCalled();

        $this->manageTransaction($input);
    }
}
