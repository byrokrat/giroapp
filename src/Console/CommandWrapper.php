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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Manage the container and execute command
 */
class CommandWrapper extends Command
{
    /**
     * @var Container
     */
    private static $container;

    /**
     * @var string Name of command class
     */
    private $commandClass;

    public function __construct(string $commandClass)
    {
        $this->commandClass = $commandClass;
        parent::__construct();
    }

    public static function setContainer(Container $container): void
    {
        self::$container = $container;
    }

    protected function configure(): void
    {
        $this->commandClass::configure($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var CommandInterface $command */
        $command = self::$container->get($this->commandClass);

        /** @var CommandRunner $runner */
        $runner = self::$container->get(CommandRunner::CLASS);

        return $runner->run($command);
    }
}
