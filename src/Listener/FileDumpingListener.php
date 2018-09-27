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

namespace byrokrat\giroapp\Listener;

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Filesystem\Filesystem;
use byrokrat\giroapp\Filesystem\FilenameWriter;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

class FileDumpingListener
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var FilenameWriter
     */
    private $nameWriter;

    public function __construct(Filesystem $filesystem, FilenameWriter $nameWriter)
    {
        $this->filesystem = $filesystem;
        $this->nameWriter = $nameWriter;
    }

    public function onFileEvent(FileEvent $event, string $eventName, Dispatcher $dispatcher): void
    {
        $file = $this->nameWriter->rename($event->getFile());

        $this->filesystem->writeFile($file);

        $dispatcher->dispatch(
            Events::INFO,
            new LogEvent("Writing file <info>{$file->getFilename()}</info>")
        );
    }
}
