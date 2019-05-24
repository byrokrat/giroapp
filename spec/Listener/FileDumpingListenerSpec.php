<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileDumpingListener;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\FileProcessorInterface;
use byrokrat\giroapp\Filesystem\FileInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileDumpingListenerSpec extends ObjectBehavior
{
    function let(FilesystemInterface $fs, FileProcessorInterface $fileProcessor)
    {
        $this->beConstructedWith($fs, $fileProcessor);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileDumpingListener::CLASS);
    }

    function it_writes_imports_to_filesystem(
        $fs,
        $fileProcessor,
        FileEvent $event,
        FileInterface $file,
        FileInterface $processedFile,
        Dispatcher $dispatcher
    ) {
        $event->getFile()->willReturn($file);

        $fileProcessor->processFile($file)->willReturn($processedFile);
        $processedFile->getFilename()->willReturn('foobar');

        $fs->writeFile($processedFile)->shouldBeCalled();

        $this->onFileEvent($event);
        $this->onExecutionStoped(null, '', $dispatcher);
    }
}
