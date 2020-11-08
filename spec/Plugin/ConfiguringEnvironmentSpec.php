<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\ConfiguringEnvironment;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Plugin\ApiVersionConstraint;
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\Console\SymfonyCommandAdapter;
use byrokrat\giroapp\Console\ConsoleInterface;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Db\DriverFactoryCollection;
use byrokrat\giroapp\Db\DriverFactoryInterface;
use byrokrat\giroapp\Exception\UnsupportedVersionException;
use byrokrat\giroapp\Filter\FilterCollection;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterCollection;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Sorter\SorterCollection;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Status\StatisticInterface;
use byrokrat\giroapp\Status\StatisticsManager;
use byrokrat\giroapp\Xml\CompilerPassInterface;
use byrokrat\giroapp\Xml\XmlMandateCompiler;
use Symfony\Component\Console\Application;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Fig\EventDispatcher\AggregateProvider;
use Crell\Tukio\OrderedProviderInterface;
use Psr\Log\LoggerInterface;
use PhpSpec\ObjectBehavior;

class ConfiguringEnvironmentSpec extends ObjectBehavior
{
    function let(
        DonorQueryInterface $donorQuery,
        AggregateProvider $aggregateProvider,
        OrderedProviderInterface $orderedProvider,
        DriverFactoryCollection $dbDriverFactoryCollection,
        FilterCollection $filterCollection,
        FormatterCollection $formatterCollection,
        SorterCollection $sorterCollection,
        StatisticsManager $statisticsManager,
        ConfigManager $configManager,
        EventDispatcherInterface $dispatcher,
        CommandBusInterface $commandBus,
        LoggerInterface $logger,
        XmlMandateCompiler $xmlMandateCompiler
    ) {
        $this->beConstructedWith(
            $logger,
            $donorQuery,
            $aggregateProvider,
            $orderedProvider,
            $dbDriverFactoryCollection,
            $filterCollection,
            $formatterCollection,
            $sorterCollection,
            $statisticsManager,
            $configManager,
            $xmlMandateCompiler
        );

        $this->setEventDispatcher($dispatcher);
        $this->setCommandBus($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConfiguringEnvironment::class);
    }

    function it_is_an_environment()
    {
        $this->shouldHaveType(EnvironmentInterface::class);
    }

    function it_can_validate_version_constraints()
    {
        $this->assertApiVersion(new ApiVersionConstraint('', '*'));
    }

    function it_fails_if_version_is_not_supported()
    {
        $this->shouldThrow(UnsupportedVersionException::class)
            ->duringAssertApiVersion(new ApiVersionConstraint('', '^9999999999999999'));
    }

    function it_can_read_configs($configManager, ConfigInterface $config)
    {
        $configManager->getConfig('foo')->willReturn($config);
        $config->getValue()->willReturn('bar');
        $this->readConfig('foo')->shouldReturn('bar');
    }

    function it_contains_a_logger($logger)
    {
        $this->getLogger()->shouldReturn($logger);
    }

    function it_contains_a_command_bus($commandBus)
    {
        $this->getCommandBus()->shouldReturn($commandBus);
    }

    function it_contains_a_donor_query($donorQuery)
    {
        $this->getDonorQuery()->shouldReturn($donorQuery);
    }

    function it_can_register_plugins(PluginInterface $plugin)
    {
        $plugin->loadPlugin($this)->shouldBeCalled();
        $this->registerPlugin($plugin);
    }

    function it_can_register_consoles($dispatcher, ConsoleInterface $console, Application $application)
    {
        $this->registerConsoleCommand($console);
        $this->configureApplication($application);

        $adapter = new SymfonyCommandAdapter(
            $console->getWrappedObject(),
            $this->getWrappedObject(),
            $dispatcher->getWrappedObject()
        );

        $application->add($adapter)->shouldHaveBeenCalled();
    }

    function it_can_register_db_drivers($dbDriverFactoryCollection, DriverFactoryInterface $driverFactory)
    {
        $this->registerDatabaseDriver($driverFactory);
        $dbDriverFactoryCollection->addDriverFactory($driverFactory)->shouldHaveBeenCalled();
    }

    function it_can_register_listeners($orderedProvider)
    {
        $listener = function () {
        };
        $orderedProvider->addListener($listener, 666)->willReturn('')->shouldBeCalled();
        $this->registerListener($listener, 666);
    }

    function it_can_register_listener_providers($aggregateProvider, ListenerProviderInterface $provider)
    {
        $aggregateProvider->addProvider($provider)->willReturn($aggregateProvider)->shouldBeCalled();
        $this->registerListenerProvider($provider);
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

    function it_can_register_statistics($statisticsManager, StatisticInterface $statistic)
    {
        $this->registerStatistic($statistic);
        $statisticsManager->addStatistic($statistic)->shouldHaveBeenCalled();
    }

    function it_can_register_xml_compiler_passes($xmlMandateCompiler, CompilerPassInterface $compilerPass)
    {
        $this->registerXmlMandateCompilerPass($compilerPass);
        $xmlMandateCompiler->addCompilerPass($compilerPass)->shouldHaveBeenCalled();
    }
}
