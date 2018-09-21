<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\Filesystem;
use byrokrat\giroapp\Utils\File;
use byrokrat\giroapp\Exception\UnableToReadFileException;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use Symfony\Component\Finder\Finder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemSpec extends ObjectBehavior
{
    function let(SymfonyFilesystem $fs)
    {
        $this->beConstructedWith('', $fs);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Filesystem::CLASS);
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

    function it_fails_if_path_is_dir($fs)
    {
        $fs->exists(__DIR__)->willReturn(true);
        $fs->isAbsolutePath(__DIR__)->willReturn(true)->shouldBeCalled();
        $this->isFile(__DIR__)->shouldReturn(false);
    }

    function it_fails_reading_if_file_does_not_exist($fs)
    {
        $fs->exists('filename')->willReturn(false);
        $fs->isAbsolutePath('filename')->willReturn(true)->shouldBeCalled();
        $this->shouldThrow(UnableToReadFileException::CLASS)->during('readFile', ['filename']);
    }

    function it_can_read_absolute_paths($fs)
    {
        $fs->exists(__FILE__)->willReturn(true);
        $fs->isAbsolutePath(__FILE__)->willReturn(true)->shouldBeCalled();
        $this->readFile(__FILE__)->shouldBeLike(new File(__FILE__, file_get_contents(__FILE__)));
    }

    function it_can_read_relative_paths($fs)
    {
        $this->beConstructedWith(__DIR__, $fs);
        $filename = 'FilesystemSpec.php';
        $fs->isAbsolutePath($filename)->willReturn(false)->shouldBeCalled();
        $fs->exists(__FILE__)->willReturn(true);
        $this->readFile($filename)->shouldBeLike(new File($filename, file_get_contents(__FILE__)));
    }

    function it_can_dump_file($fs)
    {
        $fs->isAbsolutePath('name')->willReturn(true)->shouldBeCalled();
        $fs->dumpFile('name', 'content')->shouldBeCalled();
        $this->dumpFile('name', 'content');
    }

    function it_can_create_finders($fs)
    {
        $fs->isAbsolutePath(__DIR__)->willReturn(true);
        $this->getFinder(__DIR__)->shouldBeLike((new Finder)->in(__DIR__));
    }
}
