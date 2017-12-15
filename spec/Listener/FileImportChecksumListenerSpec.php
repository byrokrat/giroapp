<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileImportChecksumListener;
use byrokrat\giroapp\Mapper\FileChecksumMapper;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Model\FileChecksum;
use byrokrat\giroapp\Utils\File;
use byrokrat\giroapp\Utils\SystemClock;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileImportChecksumListenerSpec extends ObjectBehavior
{
    const FILENAME = 'foo';
    const CHECKSUM = 'bar';

    function let(
        FileChecksumMapper $fileChecksumMapper,
        SystemClock $systemClock,
        \DateTime $date,
        FileEvent $event,
        File $file
    ) {
        $systemClock->getNow()->willReturn($date);
        $this->beConstructedWith($fileChecksumMapper, $systemClock);
        $event->getFile()->willReturn($file);
        $file->getFilename()->willReturn(self::FILENAME);
        $file->getChecksum()->willReturn(self::CHECKSUM);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileImportChecksumListener::CLASS);
    }

    function it_dispatches_errors($fileChecksumMapper, $date, $event, Dispatcher $dispatcher, FileChecksum $oldImport)
    {
        $fileChecksumMapper->hasKey(self::CHECKSUM)->willReturn(true);
        $fileChecksumMapper->findByKey(self::CHECKSUM)->willReturn($oldImport);
        $oldImport->getDatetime()->willReturn($date);

        $dispatcher->dispatch(Events::ERROR, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();
        $fileChecksumMapper->insert(Argument::any())->shouldNotBeCalled();

        $this->onFileImported($event, '', $dispatcher);
    }

    function it_inserts_checksums($fileChecksumMapper, $date, $event, Dispatcher $dispatcher)
    {
        $fileChecksumMapper->hasKey(self::CHECKSUM)->willReturn(false);

        $dispatcher->dispatch(Events::ERROR, Argument::type(LogEvent::CLASS))->shouldNotBeCalled();
        $event->stopPropagation()->shouldNotBeCalled();

        $fileChecksum = new FileChecksum(self::FILENAME, self::CHECKSUM, $date->getWrappedObject());
        $fileChecksumMapper->insert($fileChecksum)->shouldBeCalled();

        $this->onFileImported($event, '', $dispatcher);
    }
}
