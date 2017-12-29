<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\FileNameDecorator;
use byrokrat\giroapp\Utils\File;
use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileNameDecoratorSpec extends ObjectBehavior
{
    function let(File $file, SystemClock $clock)
    {
        $this->beConstructedWith($file, $clock);

        $file->getFilename()->willReturn('');
        $file->getContent()->willReturn('');
        $file->getChecksum()->willReturn('');

        $clock->getNow()->willReturn(new \DateTime);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileNameDecorator::CLASS);
    }

    function it_creates_file_name($file, $clock)
    {
        $file->getFilename()->willReturn('name');
        $file->getChecksum()->willReturn('1234567890');
        $clock->getNow()->willReturn(new \DateTime('2010-01-01 01:01:01'));
        $this->getFilename()->shouldReturn('AG_20100101T010101_name_12345.txt');
    }

    function it_wrapps_content($file)
    {
        $file->getContent()->willReturn('content');
        $this->getContent()->shouldReturn('content');
    }

    function it_defaults_to_no_clock($file)
    {
        $this->beConstructedWith($file);
        $this->getFilename()->shouldBeString();
    }
}
