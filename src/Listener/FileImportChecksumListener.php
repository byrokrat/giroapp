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

use byrokrat\giroapp\Mapper\FileChecksumMapper;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Model\FileChecksum;
use byrokrat\giroapp\Utils\SystemClock;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Protect against multiple imports of the same file by storing file hashes of imported files
 */
class FileImportChecksumListener
{
    /**
     * @var FileChecksumMapper
     */
    private $fileChecksumMapper;

    /**
     * @var SystemClock
     */
    private $systemClock;

    public function __construct(FileChecksumMapper $fileChecksumMapper, SystemClock $systemClock)
    {
        $this->fileChecksumMapper = $fileChecksumMapper;
        $this->systemClock = $systemClock;
    }

    public function onImportEvent(FileEvent $event, string $eventName, EventDispatcherInterface $dispatcher): void
    {
        $file = $event->getFile();

        $fileChecksum = new FileChecksum(
            $file->getFilename(),
            $file->getChecksum(),
            $this->systemClock->getNow()
        );

        if ($this->fileChecksumMapper->hasKey($fileChecksum->getChecksum())) {
            $oldImport = $this->fileChecksumMapper->findByKey($fileChecksum->getChecksum());
            $dispatcher->dispatch(
                Events::ERROR_EVENT,
                new LogEvent(sprintf(
                    'Unable to import %s, file has been previously imported at %s (use --force to override)',
                    $file->getFilename(),
                    $oldImport->getDatetime()->format('Y-m-d')
                ))
            );
            $event->stopPropagation();
            return;
        }

        $this->fileChecksumMapper->insert($fileChecksum);
    }
}
