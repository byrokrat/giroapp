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
use byrokrat\giroapp\Utils\Filesystem;
use byrokrat\giroapp\Utils\FileNameFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

class FileDumpingListener
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var FileNameFactory
     */
    private $nameFactory;

    public function __construct(Filesystem $filesystem, FileNameFactory $nameFactory)
    {
        $this->filesystem = $filesystem;
        $this->nameFactory = $nameFactory;
    }

    public function onFileEvent(FileEvent $event, string $eventName, Dispatcher $dispatcher): void
    {
        $file = $event->getFile();

        $name = $this->filesystem->getAbsolutePath(
            $this->nameFactory->createName($file)
        );

        $this->filesystem->dumpFile($name, $file->getContent());

        $dispatcher->dispatch(
            Events::INFO,
            new LogEvent("Writing file <info>$name</info>")
        );
    }
}
