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

namespace byrokrat\giroapp\Listener;

use Symfony\Component\Console\Output\OutputInterface;
use byrokrat\giroapp\Event\LogEvent;

/**
 * Write warning, info and debug messages to output
 */
class OutputtingListener
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function onErrorEvent(LogEvent $event)
    {
        $this->output->writeln("<error>ERROR: {$event->getMessage()}</error>");
    }

    public function onWarningEvent(LogEvent $event)
    {
        $this->output->writeln("<question>WARNING: {$event->getMessage()}</question>");
    }

    public function onInfoEvent(LogEvent $event)
    {
        $this->output->writeln($event->getMessage());
    }

    public function onDebugEvent(LogEvent $event)
    {
        if ($this->output->isVerbose()) {
            $this->output->writeln($event->getMessage());
        }
    }
}
