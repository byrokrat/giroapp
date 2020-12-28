<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\StdFilesystem;
use byrokrat\giroapp\Filesystem\FileInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use byrokrat\giroapp\Exception\UnableToReadFileException;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use PhpSpec\ObjectBehavior;

class StdFilesystemSpec extends ObjectBehavior
{
    function let(SymfonyFilesystem $fs)
    {
        $this->beConstructedWith('', $fs);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StdFilesystem::class);
    }

    function it_recognizes_absolute_paths($fs)
    {
        $fs->isAbsolutePath('name')->willReturn(true);
        $this->getAbsolutePath('name')->shouldReturn('name');
    }

    function it_expands_relative_paths($fs)
    {
        $this->beConstructedWith('/base/path', $fs);
        $fs->isAbsolutePath('name')->willReturn(false);
        $this->getAbsolutePath('name')->shouldReturn('/base/path/name');
    }

    function it_can_check_if_file_exists($fs)
    {
        $fs->exists('file')->willReturn(true);
        $fs->isAbsolutePath('file')->willReturn(true)->shouldBeCalled();
        $this->exists('file')->shouldReturn(true);
    }

    function it_can_create_directories($fs)
    {
        $fs->mkdir('dirname')->shouldBeCalled();
        $fs->isAbsolutePath('dirname')->willReturn(true);
        $this->mkdir('dirname');
    }

    function it_can_check_if_path_is_file($fs)
    {
        $fs->exists(__FILE__)->willReturn(true);
        $fs->isAbsolutePath(__FILE__)->willReturn(true)->shouldBeCalled();
        $this->isFile(__FILE__)->shouldReturn(true);
    }

    function it_recognize_dirs_as_non_files($fs)
    {
        $fs->exists(__DIR__)->willReturn(true);
        $fs->isAbsolutePath(__DIR__)->willReturn(true)->shouldBeCalled();
        $this->isFile(__DIR__)->shouldReturn(false);
    }

    function it_fails_reading_if_file_does_not_exist($fs)
    {
        $fs->exists('filename')->willReturn(false);
        $fs->isAbsolutePath('filename')->willReturn(true)->shouldBeCalled();
        $this->shouldThrow(UnableToReadFileException::class)->during('readFile', ['filename']);
    }

    function it_can_read_absolute_paths($fs)
    {
        $fs->exists(__FILE__)->willReturn(true);
        $fs->isAbsolutePath(__FILE__)->willReturn(true)->shouldBeCalled();
        $this->readFile(__FILE__)->shouldBeLike(new Sha256File(basename(__FILE__), file_get_contents(__FILE__)));
    }

    function it_can_read_relative_paths($fs)
    {
        $this->beConstructedWith(__DIR__, $fs);
        $filename = 'StdFilesystemSpec.php';
        $fs->isAbsolutePath($filename)->willReturn(false)->shouldBeCalled();
        $fs->exists(__FILE__)->willReturn(true);
        $this->readFile($filename)->shouldBeLike(new Sha256File($filename, file_get_contents(__FILE__)));
    }

    function it_can_read_dir($fs)
    {
        $this->beConstructedWith(__DIR__, $fs);
        $this->readDir('.')->shouldHaveKey(__FILE__);
    }

    function it_can_write_file($fs, FileInterface $file)
    {
        $file->getFilename()->willReturn('name');
        $file->getContent()->willReturn('content');
        $fs->isAbsolutePath('name')->willReturn(true)->shouldBeCalled();
        $fs->dumpFile('name', 'content')->shouldBeCalled();
        $this->writeFile($file);
    }
}
