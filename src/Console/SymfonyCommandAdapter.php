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

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\CommandBus\Commit;
use byrokrat\giroapp\CommandBus\Rollback;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Exception as GiroappException;
use byrokrat\giroapp\Event\Listener\OutputtingListener;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final class SymfonyCommandAdapter extends Command
{
    /** @var ConsoleInterface */
    private $console;

    /** @var EnvironmentInterface */
    private $environment;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    public function __construct(
        ConsoleInterface $console,
        EnvironmentInterface $environment,
        EventDispatcherInterface $dispatcher
    ) {
        $this->console = $console;
        $this->environment = $environment;
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

        $this->environment->registerListener(new OutputtingListener($output->getErrorOutput()));

        $commandBus = $this->environment->getCommandBus();

        try {
            $this->dispatcher->dispatch(new Event\ExecutionStarted);
            $this->console->execute($input, $output);
            $commandBus->handle(new Commit);
            $this->dispatcher->dispatch(new Event\ExecutionStopped);
        } catch (GiroappException $e) {
            $this->dispatcher->dispatch(
                new Event\ErrorEvent(
                    $e->getMessage(),
                    ['code' => $e->getCode()]
                )
            );

            $commandBus->handle(new Rollback);

            return $e->getCode();
        } catch (\Exception $e) {
            $this->dispatcher->dispatch(
                new Event\ErrorEvent(
                    $e->getMessage(),
                    [
                        'class' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => (string)$e->getLine(),
                        'trace' => $e->getTraceAsString(),
                    ]
                )
            );

            if ($output->isVerbose()) {
                $output->writeln($e->getTraceAsString());
            }

            $commandBus->handle(new Rollback);

            return $e->getCode() ?: GiroappException::GENERIC_ERROR;
        }

        return 0;
    }
}
