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

namespace byrokrat\giroapp\Event;

use Psr\Log\LogLevel;

class LogEvent
{
    private const LOG_LEVEL_MAP = [
        LogLevel::EMERGENCY => 8,
        LogLevel::ALERT => 7,
        LogLevel::CRITICAL => 6,
        LogLevel::ERROR => 5,
        LogLevel::WARNING => 4,
        LogLevel::NOTICE => 3,
        LogLevel::INFO => 2,
        LogLevel::DEBUG => 1,
    ];

    /** @var string */
    private $message;

    /** @var string */
    private $severity;

    /** @var array<string> */
    private $context;

    /**
     * @param array<string> $context
     */
    public function __construct(string $message, string $severity, array $context = [])
    {
        if (!isset(self::LOG_LEVEL_MAP[$severity])) {
            throw new \LogicException("Invalid severity, use one of the psr3 LogLevel constants");
        }

        $this->message = $message;
        $this->severity = $severity;
        $this->context = $context;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getSeverity(): string
    {
        return $this->severity;
    }

    /**
     * @return array<string>
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
