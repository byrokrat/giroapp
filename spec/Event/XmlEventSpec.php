<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\XmlEvent;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Xml\XmlObject;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlEventSpec extends ObjectBehavior
{
    function let(XmlObject $xml)
    {
        $xml->asXml()->willReturn('');
        $this->beConstructedWith('', $xml);
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

    function it_contains_content($xml)
    {
        $xml->asXml()->willReturn('content');
        $this->getContents()->shouldBeLike('content');
    }

    function it_contains_a_filename($xml)
    {
        $this->beConstructedWith('filename', $xml);
        $this->getFilename()->shouldBeLike('filename');
    }

    function it_contains_a_message()
    {
        $this->getMessage()->shouldBeString();
    }

    function it_contains_a_context()
    {
        $this->getContext()->shouldBeArray();
    }
}
