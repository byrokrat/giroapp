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
use Psr\Log\LogLevel;
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
    private $errout;

    public static function getSubscribedEvents()
    {
        return [
            LogEvent::CLASS => ['onLogEvent', -10],
        ];
    }

    public function __construct(OutputInterface $errout)
    {
        $this->errout = $errout;
    }

    public function onLogEvent(LogEvent $event): void
    {
        switch ($event->getSeverity()) {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
                $this->errout->writeln("<error>ERROR: {$event->getMessage()}</error>");
                break;
            case LogLevel::WARNING:
                $this->errout->writeln("<question>WARNING: {$event->getMessage()}</question>");
                break;
            case LogLevel::NOTICE:
            case LogLevel::INFO:
                $this->errout->writeln($event->getMessage());
                break;
            case LogLevel::DEBUG:
                if ($this->errout->isVerbose()) {
                    $this->errout->writeln($event->getMessage());
                }
                break;
        }
    }
}
