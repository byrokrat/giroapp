<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\ConfiguringEnvironment;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Plugin\ApiVersion;
use byrokrat\giroapp\Plugin\ApiVersionConstraint;
use byrokrat\giroapp\Console\SymfonyCommandAdapter;
use byrokrat\giroapp\Console\ConsoleInterface;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Db\DriverFactoryCollection;
use byrokrat\giroapp\Db\DriverFactoryInterface;
use byrokrat\giroapp\Exception\UnsupportedVersionException;
use byrokrat\giroapp\Filter\FilterCollection;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterCollection;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Sorter\SorterCollection;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\Xml\XmlFormInterface;
use byrokrat\giroapp\Xml\XmlFormTranslator;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfiguringEnvironmentSpec extends ObjectBehavior
{
    function let(
        DriverFactoryCollection $dbDriverFactoryCollection,
        FilterCollection $filterCollection,
        FormatterCollection $formatterCollection,
        SorterCollection $sorterCollection,
        StateCollection $stateCollection,
        ConfigManager $configManager,
        XmlFormTranslator $xmlFormTranslator,
        EventDispatcherInterface $dispatcher,
        CommandBus $commandBus
    ) {
        $this->beConstructedWith(
            new ApiVersion('1.0'),
            $dbDriverFactoryCollection,
            $filterCollection,
            $formatterCollection,
            $sorterCollection,
            $stateCollection,
            $configManager,
            $xmlFormTranslator
        );

        $this->setEventDispatcher($dispatcher);
        $this->setCommandBus($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConfiguringEnvironment::CLASS);
    }

    function it_is_an_environment()
    {
        $this->shouldHaveType(EnvironmentInterface::CLASS);
    }

    function it_can_validate_version_constraints()
    {
        $this->assertApiVersion(new ApiVersionConstraint('', '^1'));
    }

    function it_fails_if_version_is_not_supported()
    {
        $this->shouldThrow(UnsupportedVersionException::CLASS)
            ->duringAssertApiVersion(new ApiVersionConstraint('', '^2'));
    }

    function it_can_read_configs($configManager, ConfigInterface $config)
    {
        $configManager->getConfig('foo')->willReturn($config);
        $config->getValue()->willReturn('bar');
        $this->readConfig('foo')->shouldReturn('bar');
    }

    function it_can_register_console_commands($dispatcher, $commandBus, ConsoleInterface $console, Application $application)
    {
        $this->registerConsoleCommand($console);
        $this->configureApplication($application);

        $adapter = new SymfonyCommandAdapter(
            $console->getWrappedObject(),
            $commandBus->getWrappedObject(),
            $dispatcher->getWrappedObject()
        );

        $application->add($adapter)->shouldHaveBeenCalled();
    }

    function it_can_register_db_drivers($dbDriverFactoryCollection, DriverFactoryInterface $driverFactory)
    {
        $this->registerDatabaseDriver($driverFactory);
        $dbDriverFactoryCollection->addDriverFactory($driverFactory)->shouldHaveBeenCalled();
    }

    function it_can_register_subscribers($dispatcher, EventSubscriberInterface $subscriber)
    {
        $this->registerSubscriber($subscriber);
        $dispatcher->addSubscriber($subscriber)->shouldHaveBeenCalled();
    }

    function it_can_register_filters($filterCollection, FilterInterface $filter)
    {
        $this->registerDonorFilter($filter);
        $filterCollection->addFilter($filter)->shouldHaveBeenCalled();
    }

    function it_can_register_formatters($formatterCollection, FormatterInterface $formatter)
    {
        $this->registerDonorFormatter($formatter);
        $formatterCollection->addFormatter($formatter)->shouldHaveBeenCalled();
    }

    function it_can_register_sorters($sorterCollection, SorterInterface $sorter)
    {
        $this->registerDonorSorter($sorter);
        $sorterCollection->addSorter($sorter)->shouldHaveBeenCalled();
    }

    function it_can_register_states($stateCollection, StateInterface $state)
    {
        $this->registerDonorState($state);
        $stateCollection->addState($state)->shouldHaveBeenCalled();
    }

    function it_can_register_xml_forms($xmlFormTranslator, XmlFormInterface $xmlForm)
    {
        $this->registerXmlForm($xmlForm);
        $xmlFormTranslator->addXmlForm($xmlForm)->shouldHaveBeenCalled();
    }
}
