<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileDumpingListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Utils\File;
use byrokrat\giroapp\Utils\Filesystem;
use byrokrat\giroapp\Utils\FileNameFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileDumpingListenerSpec extends ObjectBehavior
{
    function let(Filesystem $fs, FileNameFactory $nameFactory)
    {
        $this->beConstructedWith($fs, $nameFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileDumpingListener::CLASS);
    }

    function it_writes_imports_to_filesystem($fs, $nameFactory, FileEvent $event, File $file, Dispatcher $dispatcher)
    {
        $event->getFile()->willReturn($file);
        $nameFactory->createName($file)->willReturn('name');
        $fs->getAbsolutePath('name')->willReturn('absolute_path');
        $file->getContent()->willReturn('content');
        $fs->dumpFile('absolute_path', 'content')->shouldBeCalled();
        $dispatcher->dispatch(Events::INFO, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $this->onFileEvent($event, '', $dispatcher);
    }
}
