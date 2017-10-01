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

use byrokrat\giroapp\ProjectServiceContainer;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Wrapper of giroapp console commands
 */
class CommandWrapper extends Command
{
    /**
     * @var string Name of command class
     */
    private $commandClass;

    /**
     * @var bool
     */
    private $discardOutputMessages = false;

    public function __construct(string $commandClass)
    {
        $this->commandClass = $commandClass;
        parent::__construct();
    }

    /**
     * Instruct wrapper to ignore messages written to standard out
     */
    public function discardOutputMessages()
    {
        $this->discardOutputMessages = true;
    }

    /**
     * Configure the path option
     */
    protected function configure()
    {
        $this->commandClass::configure($this);
    }

    /**
     * Dispatch events and call wrapped command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = new ProjectServiceContainer;

        $container->set('output', $this->discardOutputMessages ? new NullOutput : $output);

        $dispatcher = $container->get('Symfony\Component\EventDispatcher\EventDispatcher');

        $dispatcher->dispatch(
            Events::DEBUG_EVENT,
            new LogEvent("User directory: <info>{$container->getParameter('user.dir')}</info>")
        );

        try {
            $dispatcher->dispatch(Events::EXECUTION_START_EVENT);
            $container->get($this->commandClass)->execute($input, $output);
            $dispatcher->dispatch(Events::EXECUTION_END_EVENT);
        } catch (\Exception $e) {
            $dispatcher->dispatch(
                Events::ERROR_EVENT,
                new LogEvent(
                    "[EXCEPTION] {$e->getMessage()}",
                    [
                        'class' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]
                )
            );
            throw $e;
        }
    }
}
