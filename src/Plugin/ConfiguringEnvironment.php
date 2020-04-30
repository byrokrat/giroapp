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
 * Copyright 2016-20 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Console\ConsoleInterface;
use byrokrat\giroapp\Console\SymfonyCommandAdapter;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Db\DriverFactoryCollection;
use byrokrat\giroapp\Db\DriverFactoryInterface;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Exception\UnsupportedVersionException;
use byrokrat\giroapp\Filter\FilterCollection;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterCollection;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Sorter\SorterCollection;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Xml\CompilerPassInterface;
use byrokrat\giroapp\Xml\XmlMandateCompiler;
use Composer\Semver\Semver;
use Symfony\Component\Console\Application;
use Psr\EventDispatcher\ListenerProviderInterface;
use Fig\EventDispatcher\AggregateProvider;
use Crell\Tukio\OrderedProviderInterface;
use Psr\Log\LoggerInterface;

final class ConfiguringEnvironment implements EnvironmentInterface
{
    use CommandBusProperty, DispatcherProperty;

    /** @var LoggerInterface */
    private $logger;

    /** @var ApiVersion */
    private $apiVersion;

    /** @var DonorQueryInterface */
    private $donorQuery;

    /** @var AggregateProvider */
    private $aggregateProvider;

    /** @var OrderedProviderInterface */
    private $orderedProvider;

    /** @var DriverFactoryCollection */
    private $dbDriverFactoryCollection;

    /** @var FilterCollection */
    private $filterCollection;

    /** @var FormatterCollection */
    private $formatterCollection;

    /** @var SorterCollection */
    private $sorterCollection;

    /** @var ConfigManager */
    private $configManager;

    /** @var ConsoleInterface[] */
    private $consoleCommands = [];

    /** @var XmlMandateCompiler */
    private $xmlMandateCompiler;

    public function __construct(
        LoggerInterface $logger,
        ApiVersion $apiVersion,
        DonorQueryInterface $donorQuery,
        AggregateProvider $aggregateProvider,
        OrderedProviderInterface $orderedProvider,
        DriverFactoryCollection $dbDriverFactoryCollection,
        FilterCollection $filterCollection,
        FormatterCollection $formatterCollection,
        SorterCollection $sorterCollection,
        ConfigManager $configManager,
        XmlMandateCompiler $xmlMandateCompiler
    ) {
        $this->logger = $logger;
        $this->apiVersion = $apiVersion;
        $this->donorQuery = $donorQuery;
        $this->aggregateProvider = $aggregateProvider;
        $this->orderedProvider = $orderedProvider;
        $this->dbDriverFactoryCollection = $dbDriverFactoryCollection;
        $this->filterCollection = $filterCollection;
        $this->formatterCollection = $formatterCollection;
        $this->sorterCollection = $sorterCollection;
        $this->configManager = $configManager;
        $this->xmlMandateCompiler = $xmlMandateCompiler;
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

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getCommandBus(): CommandBusInterface
    {
        return $this->commandBus;
    }

    public function getDonorQuery(): DonorQueryInterface
    {
        return $this->donorQuery;
    }

    public function registerPlugin(PluginInterface $plugin): void
    {
        $plugin->loadPlugin($this);
    }

    public function registerConsoleCommand(ConsoleInterface $consoleCommand): void
    {
        $this->consoleCommands[] = $consoleCommand;
    }

    public function registerDatabaseDriver(DriverFactoryInterface $driverFactory): void
    {
        $this->dbDriverFactoryCollection->addDriverFactory($driverFactory);
    }

    public function registerListener(callable $listener): void
    {
        $this->orderedProvider->addListener($listener);
    }

    public function registerListenerProvider(ListenerProviderInterface $provider): void
    {
        $this->aggregateProvider->addProvider($provider);
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

    public function registerXmlMandateCompilerPass(CompilerPassInterface $compilerPass): void
    {
        $this->xmlMandateCompiler->addCompilerPass($compilerPass);
    }

    public function configureApplication(Application $application): void
    {
        foreach ($this->consoleCommands as $consoleCommand) {
            $application->add(new SymfonyCommandAdapter($consoleCommand, $this, $this->dispatcher));
        }
    }
}
