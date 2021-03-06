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

namespace byrokrat\giroapp\Db\Json;

use byrokrat\giroapp\Db\ImportHistoryInterface;
use byrokrat\giroapp\Exception\FileAlreadyImportedException;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Domain\FileThatWasImported;
use byrokrat\giroapp\Utils\SystemClock;
use hanneskod\yaysondb\CollectionInterface;

final class JsonImportHistory implements ImportHistoryInterface
{
    public const TYPE = 'giroapp/import_history:1.0';

    /** @var CollectionInterface&iterable<array> */
    private $collection;

    /** @var SystemClock */
    private $systemClock;

    /**
     * @param CollectionInterface&iterable<array> $collection
     */
    public function __construct(CollectionInterface $collection, SystemClock $systemClock)
    {
        $this->collection = $collection;
        $this->systemClock = $systemClock;
    }

    public function addToImportHistory(FileInterface $file): void
    {
        if ($fileThatWasImported = $this->fileWasImported($file)) {
            throw new FileAlreadyImportedException(sprintf(
                'File %s was previously imported at %s',
                $file->getFilename(),
                $fileThatWasImported->getDatetime()->format('Ymd')
            ));
        }

        $this->collection->insert(
            [
                'type' => self::TYPE,
                'filename' => $file->getFilename(),
                'checksum' => $file->getChecksum(),
                'datetime' => $this->systemClock->getNow()->format(\DateTime::W3C)
            ],
            $file->getChecksum()
        );
    }

    public function fileWasImported(FileInterface $file): ?FileThatWasImported
    {
        if (!$this->collection->has($file->getChecksum())) {
            return null;
        }

        $data = $this->collection->read($file->getChecksum());

        return new FileThatWasImported(
            $data['filename'] ?? '',
            $data['checksum'] ?? '',
            new \DateTimeImmutable($data['datetime'] ?? '')
        );
    }
}
