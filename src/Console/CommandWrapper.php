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

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Listener\ExitStatusListener;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Wrapper of giroapp console commands
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
        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = self::$container->get(EventDispatcherInterface::CLASS);

        /** @var ExitStatusListener $exitStatusListener */
        $exitStatusListener = self::$container->get(ExitStatusListener::CLASS);

        /** @var CommandInterface $command */
        $command = self::$container->get($this->commandClass);

        try {
            $dispatcher->dispatch(
                Events::EXECUTION_STARTED,
                new LogEvent(sprintf(
                    'Execution started using: <info>%s</info>',
                    self::$container->getParameter('fs.user_dir')
                ))
            );

            $command->execute();

            $dispatcher->dispatch(
                Events::EXECUTION_STOPED,
                new LogEvent('Execution successful')
            );
        } catch (\Exception $e) {
            $dispatcher->dispatch(
                Events::ERROR,
                new LogEvent(
                    "[EXCEPTION] {$e->getMessage()}",
                    [
                        'class' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]
                )
            );
        }

        return $exitStatusListener->getExitStatus();
    }
}
