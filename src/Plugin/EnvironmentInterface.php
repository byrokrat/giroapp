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

namespace byrokrat\giroapp\Plugin;

use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\Console\ConsoleInterface;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Db\DriverFactoryInterface;
use byrokrat\giroapp\Exception\UnsupportedVersionException;
use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Formatter\FormatterInterface;
use byrokrat\giroapp\Sorter\SorterInterface;
use byrokrat\giroapp\Status\StatisticInterface;
use byrokrat\giroapp\Xml\CompilerPassInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\Log\LoggerInterface;

interface EnvironmentInterface
{
    /**
     * @throws UnsupportedVersionException If API does not satisfy constraint
     */
    public function assertApiVersion(ApiVersionConstraint $constraint): void;

    /**
     * Read a giroapp config value
     */
    public function readConfig(string $key): string;

    /**
     * Get a psr logger.
     */
    public function getLogger(): LoggerInterface;

    /**
     * Service layer hook
     */
    public function getCommandBus(): CommandBusInterface;

    /**
     * Repository read hook
     */
    public function getDonorQuery(): DonorQueryInterface;

    /**
     * Register a plugin
     */
    public function registerPlugin(PluginInterface $plugin): void;

    /**
     * Register a console command
     */
    public function registerConsoleCommand(ConsoleInterface $consoleCommand): void;

    /**
     * Register a database driver factory
     */
    public function registerDatabaseDriver(DriverFactoryInterface $driverFactory): void;

    /**
     * Register an event listener
     */
    public function registerListener(callable $listener, int $priority = 0): void;

    /**
     * Register an event listener provider
     */
    public function registerListenerProvider(ListenerProviderInterface $provider): void;

    /**
     * Register a custom donor filter
     */
    public function registerDonorFilter(FilterInterface $donorFilter): void;

    /**
     * Register a custom donor formatter
     */
    public function registerDonorFormatter(FormatterInterface $donorFormatter): void;

    /**
     * Register a custom donor sorter
     */
    public function registerDonorSorter(SorterInterface $donorSorter): void;

    /**
     * Register a status statistic
     */
    public function registerStatistic(StatisticInterface $statistic): void;

    /**
     * Register a custom XML mandate compiler pass
     */
    public function registerXmlMandateCompilerPass(CompilerPassInterface $compilerPass): void;
}
