<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileImportDumpingListener;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Utils\File;
use byrokrat\giroapp\Utils\Filesystem;
use byrokrat\giroapp\Utils\FileNameDecorator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileImportDumpingListenerSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileImportDumpingListener::CLASS);
    }

    function it_writes_imports_to_filesystem($filesystem, \DateTime $date, FileEvent $event, File $file)
    {
        $event->getFile()->willReturn($file);

        $file->getFilename()->willReturn('fname');
        $file->getContent()->willReturn('foobar');
        $file->getChecksum()->willReturn('12345');

        $filesystem->dumpFile(new FileNameDecorator($file->getWrappedObject()))->shouldBeCalled();
        $this->onFileImported($event);
    }
}
