<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileDumpingListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Filesystem\Filesystem;
use byrokrat\giroapp\Filesystem\FilenameWriter;
use byrokrat\giroapp\Filesystem\FileInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileDumpingListenerSpec extends ObjectBehavior
{
    function let(Filesystem $fs, FilenameWriter $nameWriter)
    {
        $this->beConstructedWith($fs, $nameWriter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileDumpingListener::CLASS);
    }

    function it_writes_imports_to_filesystem(
        $fs,
        $nameWriter,
        FileEvent $event,
        FileInterface $file,
        FileInterface $renamedFile,
        Dispatcher $dispatcher
    ) {
        $event->getFile()->willReturn($file);
        $nameWriter->rename($file)->willReturn($renamedFile);
        $renamedFile->getFilename()->willReturn('foobar');
        $fs->writeFile($renamedFile)->shouldBeCalled();
        $dispatcher->dispatch(Events::INFO, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $this->onFileEvent($event, '', $dispatcher);
    }
}
