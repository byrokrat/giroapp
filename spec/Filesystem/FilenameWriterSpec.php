<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\FilenameWriter;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilenameWriterSpec extends ObjectBehavior
{
    function let(SystemClock $systemClock)
    {
        $this->beConstructedWith($systemClock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilenameWriter::CLASS);
    }

    function it_renames($systemClock, FileInterface $file)
    {
        $systemClock->getNow()->willReturn(new \DateTimeImmutable('2010-01-01 01:01:01'));
        $file->getFilename()->willReturn('name');
        $file->getChecksum()->willReturn('1234567890');
        $file->getContent()->willReturn('');
        $this->rename($file)->shouldReturnFileNamed('AG_20100101T010101_name_12345.txt');
    }

    public function getMatchers(): array
    {
        return [
            'returnFileNamed' => function (FileInterface $file, string $name) {
                return $file->getFilename() == $name;
            },
        ];
    }
}
