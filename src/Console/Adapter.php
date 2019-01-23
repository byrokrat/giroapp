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

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Listener\OutputtingSubscriber;
use byrokrat\giroapp\Listener\ExitStatusSubscriber;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class Adapter extends SymfonyCommand
{
    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(CommandInterface $command, EventDispatcherInterface $dispatcher)
    {
        $this->command = $command;
        $this->dispatcher = $dispatcher;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->command->configure($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new \InvalidArgumentException('Output must implement ConsoleOutputInterface');
        }

        $exitStatus = new ExitStatusSubscriber;

        $this->dispatcher->addSubscriber($exitStatus);

        $this->dispatcher->addSubscriber(new OutputtingSubscriber($output, $output->getErrorOutput()));

        try {
            $this->dispatcher->dispatch(Events::EXECUTION_STARTED, new LogEvent('Execution started'));
            $this->command->execute($input, $output);
            $this->dispatcher->dispatch(Events::EXECUTION_STOPED, new LogEvent('Execution successful'));
        } catch (\Exception $e) {
            $this->dispatcher->dispatch(
                Events::ERROR,
                new LogEvent(
                    $e->getMessage(),
                    [
                        'class' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]
                )
            );
        }

        return $exitStatus->getExitStatus();
    }
}
