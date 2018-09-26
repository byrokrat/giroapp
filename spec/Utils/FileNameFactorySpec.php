<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\FileNameFactory;
use byrokrat\giroapp\Utils\File;
use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileNameFactorySpec extends ObjectBehavior
{
    function let(SystemClock $systemClock)
    {
        $this->beConstructedWith($systemClock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileNameFactory::CLASS);
    }

    function it_creates_file_name($systemClock, File $file)
    {
        $systemClock->getNow()->willReturn(new \DateTimeImmutable('2010-01-01 01:01:01'));
        $file->getFilename()->willReturn('name');
        $file->getChecksum()->willReturn('1234567890');
        $this->createName($file)->shouldReturn('AG_20100101T010101_name_12345.txt');
    }
}
