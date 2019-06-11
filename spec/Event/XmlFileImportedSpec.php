<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\XmlFileImported;
use byrokrat\giroapp\Event\FileImported;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlFileImportedSpec extends ObjectBehavior
{
    function let(FileInterface $file)
    {
        $this->beConstructedWith($file);
        $file->getFilename()->willReturn('foobar');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(XmlFileImported::CLASS);
    }

    function it_is_a_file_imported_event()
    {
        $this->shouldHaveType(FileImported::CLASS);
    }

    function it_contains_a_file($file)
    {
        $this->getFile()->shouldReturn($file);
    }

    function it_contains_a_message($file, $xml)
    {
        $this->getMessage()->shouldBeString();
    }
}
