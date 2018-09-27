<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlEventSpec extends ObjectBehavior
{
    function let(FileInterface $file, XmlObject $xml)
    {
        $this->beConstructedWith('', $file, $xml);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(XmlEvent::CLASS);
    }

    function it_is_a_file_event()
    {
        $this->shouldHaveType(FileEvent::CLASS);
    }

    function it_contains_xml_object($xml)
    {
        $this->getXmlObject()->shouldReturn($xml);
    }

    function it_contains_a_file($file)
    {
        $this->getFile()->shouldReturn($file);
    }

    function it_contains_a_message($file, $xml)
    {
        $this->beConstructedWith('message', $file, $xml);
        $this->getMessage()->shouldReturn('message');
    }
}
