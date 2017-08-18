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

use hanneskod\yaysondb\Yaysondb;

/**
 * Protect against multiple imports of the same file by storing file hashes of imported files
 */
class FileChecksumListener
{
    /**
     * @var FileChecksumMapper
     */
    private $fileChecksumMapper;

    public function __construct(FileChecksumMapper $fileChecksumMapper)
    {
        $this->fileChecksumMapper = $fileChecksumMapper;
    }

    public function importEvent(ImportEvent $file, EventDispatcherInterface $dispatcher)
    {
        $fileChecksum = hash('sha256', $file->getContents());

        if ($this->fileChecksumMapper->has($fileChecksum)) {
            $preExistingFile = $this->fileChecksumMapper->findByKey($fileChecksum);
            $dispatcher->dispatch(
                Events::ERROR_EVENT,
                new LogEvent(
                    'File has been previously imported',
                    [
                        'rejected file' => $file->getFilename(),
                        'pre-existing file' => $preExistingFile['filename'],
                        'previous import date' => $preExistingFile['date'],
                    ]
                )
            );

            $event->stopPropagation();
            return;
        }

        $this->fileChecksumMapper->save(
            $fileChecksum, [
                'filename' => $file->getFilename(),
                'date' => date('Y/m/d H:i:s')
            ]
        );
    }
}
