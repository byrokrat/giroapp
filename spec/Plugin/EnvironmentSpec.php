<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\Environment;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Console\Adapter;
use byrokrat\giroapp\Console\CommandInterface;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Filter\FilterContainer;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterContainer;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Sorter\SorterContainer;
use byrokrat\giroapp\Sorter\SorterInterface;
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
        FilterContainer $filterContainer,
        FormatterContainer $formatterContainer,
        SorterContainer $sorterContainer,
        ConfigManager $configManager,
        XmlFormTranslator $xmlFormTranslator
    ) {
        $this->beConstructedWith(
            $application,
            $dispatcher,
            $filterContainer,
            $formatterContainer,
            $sorterContainer,
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

    function it_can_register_filters($filterContainer, FilterInterface $filter)
    {
        $this->registerDonorFilter($filter);
        $filterContainer->addFilter($filter)->shouldHaveBeenCalled();
    }

    function it_can_register_formatters($formatterContainer, FormatterInterface $formatter)
    {
        $this->registerDonorFormatter($formatter);
        $formatterContainer->addFormatter($formatter)->shouldHaveBeenCalled();
    }

    function it_can_register_sorters($sorterContainer, SorterInterface $sorter)
    {
        $this->registerDonorSorter($sorter);
        $sorterContainer->addSorter($sorter)->shouldHaveBeenCalled();
    }

    function it_can_register_xml_forms($xmlFormTranslator, XmlFormInterface $xmlForm)
    {
        $this->registerXmlForm($xmlForm);
        $xmlFormTranslator->addXmlForm($xmlForm)->shouldHaveBeenCalled();
    }
}
