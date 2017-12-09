<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\FileReader;
use byrokrat\giroapp\Utils\File;
use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileReaderSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileReader::CLASS);
    }

    function it_fails_if_file_does_not_exist($filesystem)
    {
        $filesystem->has('does-not-exist')->willReturn(false);
        $this->shouldThrow(\RuntimeException::CLASS)->duringReadFile('does-not-exist');
    }

    function it_can_read_content($filesystem)
    {
        $filesystem->has('filename')->willReturn(true);
        $filesystem->read('filename')->willReturn('foobar');
        $this->readFile('filename')->shouldBeLike(new File('filename', 'foobar'));
    }
}
