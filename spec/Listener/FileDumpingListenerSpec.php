<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileDumpingListener;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\FileProcessorInterface;
use byrokrat\giroapp\Filesystem\FileInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
        $this->shouldHaveType(FileDumpingListener::CLASS);
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

        $dispatcher->dispatch(LogEvent::CLASS, Argument::type(LogEvent::CLASS))->shouldBeCalled();

        $this->onFileEvent($event);
        $this->onExecutionStopped();
    }
}
