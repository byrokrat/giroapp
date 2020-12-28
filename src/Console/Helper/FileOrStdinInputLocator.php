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

namespace byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use Streamer\Stream;

final class FileOrStdinInputLocator
{
    /** @var FilesystemInterface */
    private $filesystem;

    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param array<string> $paths
     * @return \Generator<FileInterface>
     */
    public function getFiles(array $paths): \Generator
    {
        if (empty($paths) && defined('STDIN')) {
            yield new Sha256File('STDIN', (new Stream(STDIN))->getContent());
        }

        foreach ($paths as $path) {
            if ($this->filesystem->isFile($path)) {
                yield $this->filesystem->readFile($path);
                continue;
            }

            foreach ($this->filesystem->readDir($path) as $file) {
                yield $file;
            }
        }
    }
}
