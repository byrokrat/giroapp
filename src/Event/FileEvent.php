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

namespace byrokrat\giroapp\Event;

/**
 * Dispatched when a file is imported
 */
class FileEvent extends LogEvent
{
    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $contents;

    /**
     * Load content to import
     */
    public function __construct(string $filename, string $contents)
    {
        parent::__construct("Importing file <info>$filename</info>", ['filename' => 'filename']);
        $this->filename = $filename;
        $this->contents = $contents;
    }

    /**
     * Get name of file to import
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Get content to import
     */
    public function getContents(): string
    {
        return $this->contents;
    }
}