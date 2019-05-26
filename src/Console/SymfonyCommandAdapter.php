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

use byrokrat\giroapp\CommandBus\Commit;
use byrokrat\giroapp\CommandBus\Rollback;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Exception as GiroappException;
use byrokrat\giroapp\Listener\OutputtingSubscriber;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class SymfonyCommandAdapter extends Command
{
    /** @var ConsoleInterface */
    private $console;

    /** @var CommandBus */
    private $commandBus;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(
        ConsoleInterface $console,
        CommandBus $commandBus,
        EventDispatcherInterface $dispatcher
    ) {
        $this->console = $console;
        $this->commandBus = $commandBus;
        $this->dispatcher = $dispatcher;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->console->configure($this);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new \InvalidArgumentException('Output must implement ConsoleOutputInterface');
        }

        $this->dispatcher->addSubscriber(new OutputtingSubscriber($output->getErrorOutput()));

        try {
            $this->dispatcher->dispatch(Events::EXECUTION_STARTED, new LogEvent('Execution started'));
            $this->console->execute($input, $output);
            $this->commandBus->handle(new Commit);
            $this->dispatcher->dispatch(Events::EXECUTION_STOPED, new LogEvent('Execution successful'));
        } catch (GiroappException $e) {
            $this->dispatcher->dispatch(
                Events::ERROR,
                new LogEvent(
                    $e->getMessage(),
                    [
                        'code' => $e->getCode(),
                    ]
                )
            );

            $this->commandBus->handle(new Rollback);

            return $e->getCode();
        } catch (\Exception $e) {
            $this->dispatcher->dispatch(
                Events::ERROR,
                new LogEvent(
                    $e->getMessage(),
                    [
                        'class' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ]
                )
            );

            $this->commandBus->handle(new Rollback);

            return $e->getCode() ?: GiroappException::GENERIC_ERROR;
        }

        return 0;
    }
}
