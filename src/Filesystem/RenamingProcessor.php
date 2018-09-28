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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Utils\SystemClock;

final class RenamingProcessor implements FileProcessorInterface
{
    const PREFIX = 'AG';

    /**
     * @var SystemClock
     */
    private $systemClock;

    public function __construct(SystemClock $systemClock)
    {
        $this->systemClock = $systemClock;
    }

    public function processFile(FileInterface $file): FileInterface
    {
        return new HashedFile(
            sprintf(
                '%s_%s_%s_%s.txt',
                self::PREFIX,
                $this->systemClock->getNow()->format('Ymd\THis'),
                $file->getFilename(),
                substr($file->getChecksum(), 0, 5)
            ),
            $file->getContent(),
            $file->getChecksum()
        );
    }
}
