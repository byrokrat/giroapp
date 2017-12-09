<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\ImportingListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Utils\File;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportingListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ImportingListener::CLASS);
    }

    function it_dispatches_import_xml_event(FileEvent $event, File $file, EventDispatcherInterface $dispatcher)
    {
        $event->getFile()->willReturn($file);

        $file->getFilename()->willReturn('');
        $file->getContent()->willReturn('<xml></xml>');

        $dispatcher->dispatch(Events::IMPORT_XML_EVENT, Argument::type(XmlEvent::CLASS))->shouldBeCalled();

        $this->onImportEvent($event, '', $dispatcher);
    }

    function it_dispatches_import_autogiro_event(FileEvent $event, File $file, EventDispatcherInterface $dispatcher)
    {
        $event->getFile()->willReturn($file);

        $file->getFilename()->willReturn('');
        $file->getContent()->willReturn('this-is-not-valid-xml');

        $dispatcher->dispatch(Events::IMPORT_AUTOGIRO_EVENT, $event)->shouldBeCalled();

        $this->onImportEvent($event, '', $dispatcher);
    }
}
