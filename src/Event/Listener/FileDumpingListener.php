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

namespace byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Event\ChangesCommitted;
use byrokrat\giroapp\Event\ChangesDiscarded;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\DebugEvent;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\FileProcessorInterface;

final class FileDumpingListener
{
    use DispatcherProperty;

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @var FileProcessorInterface
     */
    private $fileProcessor;

    /**
     * @var FileInterface[]
     */
    private $files = [];

    public function __construct(FilesystemInterface $filesystem, FileProcessorInterface $fileProcessor)
    {
        $this->filesystem = $filesystem;
        $this->fileProcessor = $fileProcessor;
    }

    public function onFileEvent(FileEvent $event): void
    {
        $this->files[] = $event->getFile();
    }

    public function onChangesCommitted(ChangesCommitted $event): void
    {
        foreach ($this->files as $file) {
            $file = $this->fileProcessor->processFile($file);

            $this->dispatcher->dispatch(
                new DebugEvent("Dumping file '{$file->getFilename()}'")
            );

            $this->filesystem->writeFile($file);
        }
    }

    public function onChangesDiscarded(ChangesDiscarded $event): void
    {
        $this->files = [];
    }
}
