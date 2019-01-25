<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\Environment;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Console\Adapter;
use byrokrat\giroapp\Console\CommandInterface;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\ConfigInterface;
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
use Symfony\Component\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnvironmentSpec extends ObjectBehavior
{
    function let(
        Application $application,
        EventDispatcherInterface $dispatcher,
        FilterCollection $filterCollection,
        FormatterCollection $formatterCollection,
        SorterCollection $sorterCollection,
        StateCollection $stateCollection,
        ConfigManager $configManager,
        XmlFormTranslator $xmlFormTranslator
    ) {
        $this->beConstructedWith(
            $application,
            $dispatcher,
            $filterCollection,
            $formatterCollection,
            $sorterCollection,
            $stateCollection,
            $configManager,
            $xmlFormTranslator
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Environment::CLASS);
    }

    function it_is_an_environment()
    {
        $this->shouldHaveType(EnvironmentInterface::CLASS);
    }

    function it_can_read_configs($configManager, ConfigInterface $config)
    {
        $configManager->getConfig('foo')->willReturn($config);
        $config->getValue()->willReturn('bar');
        $this->readConfig('foo')->shouldReturn('bar');
    }

    function it_can_register_commands($application, $dispatcher, CommandInterface $command)
    {
        $this->registerCommand($command);
        $adapter = new Adapter($command->getWrappedObject(), $dispatcher->getWrappedObject());
        $application->add($adapter)->shouldHaveBeenCalled();
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
