<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\FileImportingListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Utils\File;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileImportingListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FileImportingListener::CLASS);
    }

    function it_dispatches_import_xml_event(FileEvent $event, File $file, Dispatcher $dispatcher)
    {
        $event->getFile()->willReturn($file);
        $event->getMessage()->willReturn('');

        $file->getFilename()->willReturn('');
        $file->getContent()->willReturn('<xml></xml>');

        $dispatcher->dispatch(Events::XML_FILE_IMPORTED, Argument::type(XmlEvent::CLASS))->shouldBeCalled();

        $this->onFileImported($event, '', $dispatcher);
    }

    function it_dispatches_import_autogiro_event(FileEvent $event, File $file, Dispatcher $dispatcher)
    {
        $event->getFile()->willReturn($file);
        $event->getMessage()->willReturn('');

        $file->getFilename()->willReturn('');
        $file->getContent()->willReturn('this-is-not-valid-xml');

        $dispatcher->dispatch(Events::AUTOGIRO_FILE_IMPORTED, $event)->shouldBeCalled();

        $this->onFileImported($event, '', $dispatcher);
    }
}
