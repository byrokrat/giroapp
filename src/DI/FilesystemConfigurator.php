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

namespace byrokrat\giroapp\DI;

use League\Flysystem\Filesystem;

/**
 * Created required files in filesystem
 */
class FilesystemConfigurator
{
    /**
     * @var string[]
     */
    private $requiredFiles;

    /**
     * @var string[]
     */
    private $requiredDirs;

    /**
     * @param string[] $requiredFiles List of required files
     * @param string[] $requiredDirs List of required directories
     */
    public function __construct(array $requiredFiles, array $requiredDirs)
    {
        $this->requiredFiles = $requiredFiles;
        $this->requiredDirs = $requiredDirs;
    }

    /**
     * Create required files if they dont exist
     */
    public function createFiles(Filesystem $filesystem)
    {
        foreach ($this->requiredFiles as $filename) {
            if (!$filesystem->has($filename)) {
                $filesystem->write($filename, '');
            }
        }

        foreach ($this->requiredDirs as $dirname) {
            $filesystem->createDir($dirname);
        }
    }
}
