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
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\Xml\XmlFormInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PluginSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Plugin::CLASS);
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

    function it_registers_subscribers(EventSubscriberInterface $subscriber, EnvironmentInterface $env)
    {
        $this->beConstructedWith($subscriber);
        $this->loadPlugin($env);
        $env->registerSubscriber($subscriber)->shouldHaveBeenCalled();
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

    function it_registers_states(StateInterface $state, EnvironmentInterface $env)
    {
        $this->beConstructedWith($state);
        $this->loadPlugin($env);
        $env->registerDonorState($state)->shouldHaveBeenCalled();
    }

    function it_registers_xml_forms(XmlFormInterface $xmlForm, EnvironmentInterface $env)
    {
        $this->beConstructedWith($xmlForm);
        $this->loadPlugin($env);
        $env->registerXmlForm($xmlForm)->shouldHaveBeenCalled();
    }

    function it_asserts_version_constraints(EnvironmentInterface $env)
    {
        $constraint = new ApiVersionConstraint('', '');
        $this->beConstructedWith($constraint);
        $this->loadPlugin($env);
        $env->assertApiVersion($constraint)->shouldHaveBeenCalled();
    }

    function it_takes_multiple_args(FilterInterface $filter, XmlFormInterface $xmlForm, EnvironmentInterface $env)
    {
        $this->beConstructedWith($filter, $xmlForm);
        $this->loadPlugin($env);
        $env->registerDonorFilter($filter)->shouldHaveBeenCalled();
        $env->registerXmlForm($xmlForm)->shouldHaveBeenCalled();
    }

    function it_ignore_unknowns(EnvironmentInterface $env)
    {
        $this->beConstructedWith('this-is-not-known');
        $this->loadPlugin($env);
    }
}
