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

namespace byrokrat\giroapp\Utils;

use byrokrat\giroapp\Exception\UnableToReadFileException;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use Symfony\Component\Finder\Finder;

/**
 * Wrapper class to access to file system
 */
class Filesystem
{
    /**
     * @var string
     */
    private $basePath;

    /**
     * @var SymfonyFilesystem
     */
    private $fs;

    public function __construct(string $basePath, SymfonyFilesystem $fs)
    {
        $this->basePath = $basePath;
        $this->fs = $fs;
    }

    public function getAbsolutePath(string $path = ''): string
    {
        return $this->fs->isAbsolutePath($path) ? $path : $this->basePath . DIRECTORY_SEPARATOR . $path;
    }

    public function exists(string $path = ''): bool
    {
        return $this->fs->exists($this->getAbsolutePath($path));
    }

    public function mkdir(string $path = ''): void
    {
        $this->fs->mkdir($this->getAbsolutePath($path));
    }

    public function isFile(string $path): bool
    {
        $path = $this->getAbsolutePath($path);
        return $this->fs->exists($path) && is_file($path) && is_readable($path);
    }

    /**
     * @throws UnableToReadFileException if file does not exist
     */
    public function readFile(string $path): File
    {
        if (!$this->isFile($path)) {
            throw new UnableToReadFileException("Unable to read {$path}");
        }

        return new File(
            $path,
            (string)file_get_contents($this->getAbsolutePath($path))
        );
    }

    public function dumpFile(string $path, string $content): void
    {
        $this->fs->dumpFile($this->getAbsolutePath($path), $content);
    }

    public function getFinder(string $path = ''): Finder
    {
        return (new Finder)->in($this->getAbsolutePath($path));
    }
}
