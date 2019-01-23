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

namespace byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Exception\UnableToReadFileException;
use Symfony\Component\Finder\Finder;

interface FilesystemInterface
{
    /**
     * Compute absolute path based on current working directory
     */
    public function getAbsolutePath(string $path): string;

    /**
     * Check if path exists
     */
    public function exists(string $path): bool;

    /**
     * Create directory
     */
    public function mkdir(string $path): void;

    /**
     * Check if path exists and is a readable file
     */
    public function isFile(string $path): bool;

    /**
     * Read a file from filesystem
     *
     * @throws UnableToReadFileException if file does not exist
     */
    public function readFile(string $path): FileInterface;

    /**
     * Write a file to filesystem
     */
    public function writeFile(FileInterface $file): void;

    /**
     * Get finder for path
     */
    public function getFinderFor(string $path): Finder;
}
