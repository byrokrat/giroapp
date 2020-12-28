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

declare(strict_types=1);

namespace byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;

final class OutputtingListener implements ListenerInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function __invoke(LogEvent $event): void
    {
        switch ($event->getSeverity()) {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
                $this->output->writeln("<error>ERROR: {$event->getMessage()}</error>");
                break;
            case LogLevel::WARNING:
                $this->output->writeln("<question>WARNING: {$event->getMessage()}</question>");
                break;
            case LogLevel::NOTICE:
            case LogLevel::INFO:
                $this->output->writeln($event->getMessage());
                break;
            case LogLevel::DEBUG:
                if ($this->output->isVerbose()) {
                    $this->output->writeln($event->getMessage());
                }
                break;
        }
    }
}
