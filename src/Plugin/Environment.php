<?php
/**
 * This file is part of byrokrat\giroapp.
 *
 * byrokrat\giroapp is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * byrokrat\giroapp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with byrokrat\giroapp. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Console\Adapter;
use byrokrat\giroapp\Console\CommandInterface;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Filter\FilterContainer;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterContainer;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Xml\XmlFormInterface;
use byrokrat\giroapp\Xml\XmlFormTranslator;
use Symfony\Component\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class Environment implements EnvironmentInterface
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var FilterContainer
     */
    private $filterContainer;

    /**
     * @var FormatterContainer
     */
    private $formatterContainer;

    /**
     * @var ConfigManager
     */
    private $configManager;

    /**
     * @var XmlFormTranslator
     */
    private $xmlFormTranslator;

    public function __construct(
        Application $application,
        EventDispatcherInterface $dispatcher,
        FilterContainer $filterContainer,
        FormatterContainer $formatterContainer,
        ConfigManager $configManager,
        XmlFormTranslator $xmlFormTranslator
    ) {
        $this->application = $application;
        $this->dispatcher = $dispatcher;
        $this->filterContainer = $filterContainer;
        $this->formatterContainer = $formatterContainer;
        $this->configManager = $configManager;
        $this->xmlFormTranslator = $xmlFormTranslator;
    }

    public function readConfig(string $key): string
    {
        return (string)$this->configManager->getConfig($key)->getValue();
    }

    public function registerCommand(CommandInterface $command): void
    {
        $this->application->add(new Adapter($command, $this->dispatcher));
    }

    public function registerSubscriber(EventSubscriberInterface $subscriber): void
    {
        $this->dispatcher->addSubscriber($subscriber);
    }

    public function registerDonorFilter(FilterInterface $donorFilter): void
    {
        $this->filterContainer->addFilter($donorFilter);
    }

    public function registerDonorFormatter(FormatterInterface $donorFormatter): void
    {
        $this->formatterContainer->addFormatter($donorFormatter);
    }

    public function registerXmlForm(XmlFormInterface $xmlForm): void
    {
        $this->xmlFormTranslator->addXmlForm($xmlForm);
    }
}
