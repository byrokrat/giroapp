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
 * Copyright 2016-21 Hannes Forsgård
 */

declare(strict_types=1);

namespace byrokrat\giroapp\Utils;

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Event\LogEvent;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

final class DispatchingLogger implements LoggerInterface
{
    use DispatcherProperty;
    use LoggerTrait;

    /**
     * @param mixed $level
     * @param string $message
     * @param array<string> $context
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        if (!is_scalar($level)) {
            throw new \InvalidArgumentException('$level must be a scalar value');
        }

        if (!is_scalar($message)) {
            throw new \InvalidArgumentException('$message must be a scalar value');
        }

        $this->dispatcher->dispatch(
            new LogEvent((string)$message, (string)$level, $context)
        );
    }
}
