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
use Composer\Semver\Semver;
use Symfony\Component\Console\Application;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ConfiguringEnvironment implements EnvironmentInterface
{
    /**
     * @var ApiVersion
     */
    private $apiVersion;

    /**
     * @var DriverFactoryCollection
     */
    private $dbDriverFactoryCollection;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var FilterCollection
     */
    private $filterCollection;

    /**
     * @var FormatterCollection
     */
    private $formatterCollection;

    /**
     * @var SorterCollection
     */
    private $sorterCollection;

    /**
     * @var StateCollection
     */
    private $stateCollection;

    /**
     * @var ConfigManager
     */
    private $configManager;

    /**
     * @var XmlFormTranslator
     */
    private $xmlFormTranslator;

    /**
     * @var CommandInterface[]
     */
    private $commands = [];

    public function __construct(
        ApiVersion $apiVersion,
        DriverFactoryCollection $dbDriverFactoryCollection,
        EventDispatcherInterface $dispatcher,
        FilterCollection $filterCollection,
        FormatterCollection $formatterCollection,
        SorterCollection $sorterCollection,
        StateCollection $stateCollection,
        ConfigManager $configManager,
        XmlFormTranslator $xmlFormTranslator
    ) {
        $this->apiVersion = $apiVersion;
        $this->dbDriverFactoryCollection = $dbDriverFactoryCollection;
        $this->dispatcher = $dispatcher;
        $this->filterCollection = $filterCollection;
        $this->formatterCollection = $formatterCollection;
        $this->sorterCollection = $sorterCollection;
        $this->stateCollection = $stateCollection;
        $this->configManager = $configManager;
        $this->xmlFormTranslator = $xmlFormTranslator;
    }

    public function assertApiVersion(ApiVersionConstraint $constraint): void
    {
        if (!Semver::satisfies($this->apiVersion->getVersion(), $constraint->getConstraint())) {
            throw new UnsupportedVersionException(sprintf(
                'API version %s does not satisfy constraint %s in %s',
                $this->apiVersion->getVersion(),
                $constraint->getConstraint(),
                $constraint->getName()
            ));
        }
    }

    public function readConfig(string $key): string
    {
        return $this->configManager->getConfig($key)->getValue();
    }

    public function registerCommand(CommandInterface $command): void
    {
        $this->commands[] = $command;
    }

    public function registerDatabaseDriver(DriverFactoryInterface $driverFactory): void
    {
        $this->dbDriverFactoryCollection->addDriverFactory($driverFactory);
    }

    public function registerSubscriber(EventSubscriberInterface $subscriber): void
    {
        $this->dispatcher->addSubscriber($subscriber);
    }

    public function registerDonorFilter(FilterInterface $donorFilter): void
    {
        $this->filterCollection->addFilter($donorFilter);
    }

    public function registerDonorFormatter(FormatterInterface $donorFormatter): void
    {
        $this->formatterCollection->addFormatter($donorFormatter);
    }

    public function registerDonorSorter(SorterInterface $donorSorter): void
    {
        $this->sorterCollection->addSorter($donorSorter);
    }

    public function registerDonorState(StateInterface $donorState): void
    {
        $this->stateCollection->addState($donorState);
    }

    public function registerXmlForm(XmlFormInterface $xmlForm): void
    {
        $this->xmlFormTranslator->addXmlForm($xmlForm);
    }

    public function configureApplication(Application $application): void
    {
        foreach ($this->commands as $command) {
            $application->add(new Adapter($command, $this->dispatcher));
        }
    }
}
