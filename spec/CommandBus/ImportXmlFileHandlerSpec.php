<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\ImportXmlFileHandler;
use byrokrat\giroapp\CommandBus\ImportXmlFile;
use byrokrat\giroapp\Event\XmlFileImported;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Xml\XmlMandateProcessor;
use byrokrat\giroapp\Xml\XmlObject;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportXmlFileHandlerSpec extends ObjectBehavior
{
    function let(XmlMandateProcessor $xmlProcessor, EventDispatcherInterface $dispatcher)
    {
        $this->beConstructedWIth($xmlProcessor);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportXmlFileHandler::CLASS);
    }

    function it_imports_xml_objects($xmlProcessor, $dispatcher, FileInterface $file, XmlObject $xml)
    {
        $file->getFilename()->wilLReturn('');

        $xmlProcessor->process($xml)->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(XmlFileImported::CLASS))->shouldBeCalled();

        $this->handle(new ImportXmlFile($file->getWrappedObject(), $xml->getWrappedObject()));
    }
}
