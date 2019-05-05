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

declare(strict_types = 1);

namespace byrokrat\giroapp\Filesystem;

final class FilesystemConfigurator
{
    /** @var string[] */
    private $requiredDirs;

    /** @var string[] */
    private $requiredFiles;

    /**
     * @param string[] $requiredDirs
     * @param string[] $requiredFiles
     */
    public function __construct(array $requiredDirs = [], array $requiredFiles = [])
    {
        $this->requiredDirs = $requiredDirs;
        $this->requiredFiles = $requiredFiles;
    }

    public function createFiles(FilesystemInterface $filesystem): void
    {
        foreach ($this->requiredDirs as $dirname) {
            if (!$filesystem->exists($dirname)) {
                $filesystem->mkdir($dirname);
            }
        }

        foreach ($this->requiredFiles as $filename) {
            if (!$filesystem->exists($filename)) {
                $filesystem->writeFile(new Sha256File($filename, ''));
            }
        }
    }
}
