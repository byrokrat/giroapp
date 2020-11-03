<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\Listener\FileDumpingListener;
use byrokrat\giroapp\Event\ChangesCommitted;
use byrokrat\giroapp\Event\ChangesDiscarded;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\FileProcessorInterface;
use byrokrat\giroapp\Filesystem\FileInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileDumpingListenerSpec extends ObjectBehavior
{
    function let(FilesystemInterface $fs, FileProcessorInterface $fileProcessor, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWith($fs, $fileProcessor);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileDumpingListener::class);
    }

    function it_writes_imports_to_filesystem(
        $fs,
        $fileProcessor,
        $dispatcher,
        FileEvent $event,
        FileInterface $file,
        FileInterface $processedFile
    ) {
        $event->getFile()->willReturn($file);

        $fileProcessor->processFile($file)->willReturn($processedFile);
        $processedFile->getFilename()->willReturn('foobar');

        $fs->writeFile($processedFile)->shouldBeCalled();

        $dispatcher->dispatch(Argument::type(LogEvent::class))->shouldBeCalled();

        $this->onFileEvent($event);
        $this->onChangesCommitted(new ChangesCommitted);
    }

    function it_discards_changes($fs, FileEvent $event, FileInterface $file)
    {
        $event->getFile()->willReturn($file);

        $fs->writeFile(Argument::any())->shouldNotBeCalled();

        $this->onFileEvent($event);
        $this->onChangesDiscarded(new ChangesDiscarded);
        $this->onChangesCommitted(new ChangesCommitted);
    }
}
