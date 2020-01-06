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

namespace byrokrat\giroapp\Db;

use byrokrat\giroapp\Exception\FileAlreadyImportedException;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Domain\FileThatWasImported;

/**
 * Defines the interface for interacting with the import history repository
 *
 * All concrete database layers must contain an implementation of this interface
 */
interface ImportHistoryInterface
{
    /**
     * @throws FileAlreadyImportedException If file was previously imported
     */
    public function addToImportHistory(FileInterface $file): void;

    /**
     * Check if file was previously imported
     */
    public function fileWasImported(FileInterface $file): ?FileThatWasImported;
}
