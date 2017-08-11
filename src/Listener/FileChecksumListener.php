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
 * Filter NodeEvents where payee information does not match local registry
 */
class FileChecksumListener
{
    /**
     * @var Yaysondb
     */
    private $db;

    public function __construct(Yaysondb $db)
    {
        $this->db = $db;
    }

    public function onImportEvent(ImportEvent $file)
    {
        $filename = $file->getFilename();
        $fileChecksum = hash(sha256, $file->getContents());

        if ($this->db->has($fileChecksum) {
            $dispatcher->dispatch(
                Events::ERROR_EVENT,
                new LogEvent(
                    'File has been previously imported',
                    ['file' => explode(', ', $file)]
                )
            );

            $event->stopPropagation();
        }

        $this->db->insert([
            $fileChecksum => [
                'filename' => $filename,
                'date' => date('Y/m/d H:i:s')
            ]
        ]);
    }
}
