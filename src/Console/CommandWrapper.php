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

use byrokrat\giroapp\DependencyInjection\ProjectServiceContainer;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\StreamOutput;
use Streamer\Stream;

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
    public function discardOutputMessages(): void
    {
        $this->discardOutputMessages = true;
    }

    protected function configure(): void
    {
        $this->commandClass::configure($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $container = new ProjectServiceContainer;

        $container->set(InputInterface::CLASS, $input);
        $container->set('std_out', $this->discardOutputMessages ? new NullOutput : $output);
        $container->set('err_out', new StreamOutput(STDERR, $output->getVerbosity()));
        $container->set('std_in', new Stream(STDIN));
        $container->set('Symfony\Component\Console\Helper\QuestionHelper', $this->getHelper('question'));

        /** @var \Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher */
        $dispatcher = $container->get('Symfony\Component\EventDispatcher\EventDispatcherInterface');

        $dispatcher->dispatch(
            Events::DEBUG,
            new LogEvent("User directory: <info>{$container->getParameter('fs.user_dir')}</info>")
        );

        try {
            $dispatcher->dispatch(Events::EXECUTION_STARTED);
            $container->get($this->commandClass)->execute($input, $output);
            $dispatcher->dispatch(Events::EXECUTION_STOPED);
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

        return $container->get('byrokrat\giroapp\Listener\ExitStatusListener')->getExitStatus();
    }
}
