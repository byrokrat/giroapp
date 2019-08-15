<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\NullFilesystem;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Exception\UnableToReadFileException;
use PhpSpec\ObjectBehavior;

class NullFilesystemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NullFilesystem::class);
    }

    function it_returnes_absolute_paths()
    {
        $this->getAbsolutePath('name')->shouldReturn('name');
    }

    function it_can_check_if_file_exists()
    {
        $this->exists('file')->shouldReturn(false);
    }

    function it_can_create_directories()
    {
        $this->mkdir('dirname');
    }

    function it_can_check_if_path_is_file()
    {
        $this->isFile('foo')->shouldReturn(false);
    }

    function it_fails_reading_file()
    {
        $this->shouldThrow(UnableToReadFileException::class)->during('readFile', ['filename']);
    }

    function it_can_read_dir()
    {
        $this->readDir('.')->shouldReturn([]);
    }

    function it_can_write_file(FileInterface $file)
    {
        $this->writeFile($file);
    }
}
