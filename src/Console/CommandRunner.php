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
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

/**
 * Command running logic
 */
class CommandRunner
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var ExitStatusListener
     */
    private $exitStatusListener;

    public function __construct(Dispatcher $dispatcher, ExitStatusListener $exitStatusListener)
    {
        $this->dispatcher = $dispatcher;
        $this->exitStatusListener = $exitStatusListener;
    }

    public function run(CommandInterface $command): int
    {
        try {
            $this->dispatcher->dispatch(Events::EXECUTION_STARTED, new LogEvent('Execution started'));
            $command->execute();
            $this->dispatcher->dispatch(Events::EXECUTION_STOPED, new LogEvent('Execution successful'));
        } catch (\Exception $e) {
            $this->dispatcher->dispatch(
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

        return $this->exitStatusListener->getExitStatus();
    }
}
