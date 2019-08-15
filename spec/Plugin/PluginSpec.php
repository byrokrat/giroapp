<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\Plugin;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Plugin\ApiVersionConstraint;
use byrokrat\giroapp\Console\ConsoleInterface;
use byrokrat\giroapp\Db\DriverFactoryInterface;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Event\Listener\ListenerInterface;
use byrokrat\giroapp\Sorter\SorterInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use PhpSpec\ObjectBehavior;

class PluginSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Plugin::class);
    }

    function it_registers_console_commands(ConsoleInterface $console, EnvironmentInterface $env)
    {
        $this->beConstructedWith($console);
        $this->loadPlugin($env);
        $env->registerConsoleCommand($console)->shouldHaveBeenCalled();
    }

    function it_registers_database_drivers(DriverFactoryInterface $driverFactory, EnvironmentInterface $env)
    {
        $this->beConstructedWith($driverFactory);
        $this->loadPlugin($env);
        $env->registerDatabaseDriver($driverFactory)->shouldHaveBeenCalled();
    }

    function it_throws_on_non_callable_listeners(ListenerInterface $listener, EnvironmentInterface $env)
    {
        $this->beConstructedWith($listener);
        $this->shouldThrow(\LogicException::class)->duringLoadPlugin($env);
    }

    function it_registers_listeners(EnvironmentInterface $env)
    {
        $listener = new class() implements ListenerInterface {
            public function __invoke()
            {
            }
        };
        $this->beConstructedWith($listener);
        $this->loadPlugin($env);
        $env->registerListener($listener)->shouldHaveBeenCalled();
    }

    function it_registers_listener_providers(ListenerProviderInterface $provider, EnvironmentInterface $env)
    {
        $this->beConstructedWith($provider);
        $this->loadPlugin($env);
        $env->registerListenerProvider($provider)->shouldHaveBeenCalled();
    }

    function it_registers_filters(FilterInterface $filter, EnvironmentInterface $env)
    {
        $this->beConstructedWith($filter);
        $this->loadPlugin($env);
        $env->registerDonorFilter($filter)->shouldHaveBeenCalled();
    }

    function it_registers_formatters(FormatterInterface $formatter, EnvironmentInterface $env)
    {
        $this->beConstructedWith($formatter);
        $this->loadPlugin($env);
        $env->registerDonorFormatter($formatter)->shouldHaveBeenCalled();
    }

    function it_registers_sorters(SorterInterface $sorter, EnvironmentInterface $env)
    {
        $this->beConstructedWith($sorter);
        $this->loadPlugin($env);
        $env->registerDonorSorter($sorter)->shouldHaveBeenCalled();
    }

    function it_asserts_version_constraints(EnvironmentInterface $env)
    {
        $constraint = new ApiVersionConstraint('', '');
        $this->beConstructedWith($constraint);
        $this->loadPlugin($env);
        $env->assertApiVersion($constraint)->shouldHaveBeenCalled();
    }

    function it_takes_multiple_args(FilterInterface $filter, SorterInterface $sorter, EnvironmentInterface $env)
    {
        $this->beConstructedWith($filter, $sorter);
        $this->loadPlugin($env);
        $env->registerDonorFilter($filter)->shouldHaveBeenCalled();
        $env->registerDonorSorter($sorter)->shouldHaveBeenCalled();
    }

    function it_throws_on_unknowns(EnvironmentInterface $env)
    {
        $this->beConstructedWith('this-is-not-known');
        $this->shouldThrow(\InvalidArgumentException::class)->duringLoadPlugin($env);
    }
}
