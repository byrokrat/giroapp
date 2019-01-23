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

namespace byrokrat\giroapp\Listener;

use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Events;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Write warning, info and debug messages to output
 */
final class OutputtingSubscriber implements EventSubscriberInterface
{
    /**
     * @var OutputInterface
     */
    private $stdout;

    /**
     * @var OutputInterface
     */
    private $errout;

    public static function getSubscribedEvents()
    {
        return [
            Events::ERROR => ['onError', -10],
            Events::WARNING => ['onWarning', -10],
            Events::INFO => ['onInfo', -10],
            Events::DEBUG => ['onDebug', -10],
        ];
    }

    public function __construct(OutputInterface $stdout, OutputInterface $errout)
    {
        $this->stdout = $stdout;
        $this->errout = $errout;
    }

    public function onError(LogEvent $event): void
    {
        $this->errout->writeln("<error>ERROR: {$event->getMessage()}</error>");
    }

    public function onWarning(LogEvent $event): void
    {
        $this->errout->writeln("<question>WARNING: {$event->getMessage()}</question>");
    }

    public function onInfo(LogEvent $event): void
    {
        $this->stdout->writeln($event->getMessage());
    }

    public function onDebug(LogEvent $event): void
    {
        if ($this->stdout->isVerbose()) {
            $this->stdout->writeln($event->getMessage());
        }
    }
}
