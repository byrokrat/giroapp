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

declare(strict_types=1);

namespace byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Exception\UnableToReadFileException;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use Symfony\Component\Finder\Finder;

final class StdFilesystem implements FilesystemInterface
{
    /** @var string */
    private $baseDir;

    /** @var SymfonyFilesystem */
    private $fs;

    public function __construct(string $baseDir, SymfonyFilesystem $fs)
    {
        $this->baseDir = $baseDir;
        $this->fs = $fs;
    }

    public function getAbsolutePath(string $path): string
    {
        return $this->fs->isAbsolutePath($path) ? $path : $this->baseDir . DIRECTORY_SEPARATOR . $path;
    }

    public function exists(string $path): bool
    {
        return $this->fs->exists($this->getAbsolutePath($path));
    }

    public function mkdir(string $path): void
    {
        $this->fs->mkdir($this->getAbsolutePath($path));
    }

    public function isFile(string $path): bool
    {
        $path = $this->getAbsolutePath($path);
        return $this->fs->exists($path) && is_file($path) && is_readable($path);
    }

    public function readFile(string $path): FileInterface
    {
        if (!$this->isFile($path)) {
            throw new UnableToReadFileException("Unable to read {$this->getAbsolutePath($path)}");
        }

        return new Sha256File(
            basename($path),
            (string)file_get_contents($this->getAbsolutePath($path))
        );
    }

    public function readDir(string $path): iterable
    {
        foreach ((new Finder())->in($this->getAbsolutePath($path))->files() as $fileInfo) {
            yield $fileInfo->getRealPath() => new Sha256File($fileInfo->getFilename(), $fileInfo->getContents());
        }
    }

    public function writeFile(FileInterface $file): void
    {
        $this->fs->dumpFile($this->getAbsolutePath($file->getFilename()), $file->getContent());
    }
}
