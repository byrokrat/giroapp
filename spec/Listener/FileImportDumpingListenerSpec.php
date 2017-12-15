<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileImportDumpingListener;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Utils\File;
use byrokrat\giroapp\Utils\SystemClock;
use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileImportDumpingListenerSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem, SystemClock $systemClock)
    {
        $this->beConstructedWith($filesystem, $systemClock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileImportDumpingListener::CLASS);
    }

    function it_writes_imports_to_filesystem($filesystem, $systemClock, \DateTime $date, FileEvent $event, File $file)
    {
        $event->getFile()->willReturn($file);

        $file->getFilename()->willReturn('fname');
        $file->getContent()->willReturn('foobar');

        $systemClock->getNow()->willReturn($date);
        $date->format('Ymd\TH:i:s')->willReturn('20171212T14:47:30');

        $filesystem->write('20171212T14:47:30_fname', 'foobar')->shouldBeCalled();

        $this->onFileImported($event);
    }
}
