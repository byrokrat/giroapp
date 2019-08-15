<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\RenamingProcessor;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;

class RenamingProcessorSpec extends ObjectBehavior
{
    function let(SystemClock $systemClock)
    {
        $this->beConstructedWith($systemClock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RenamingProcessor::class);
    }

    function it_renames($systemClock, FileInterface $file)
    {
        $systemClock->getNow()->willReturn(new \DateTimeImmutable('2010-01-01 01:01:01'));
        $file->getFilename()->willReturn('name');
        $file->getChecksum()->willReturn('1234567890FOO');
        $file->getContent()->willReturn('');
        $this->processFile($file)->shouldReturnFileNamed('name_20100101T010101_1234567890.txt');
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
