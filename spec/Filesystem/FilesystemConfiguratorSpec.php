<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\FilesystemConfigurator;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemConfiguratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemConfigurator::CLASS);
    }

    function it_creates_directories(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith(['foo'], []);
        $filesystem->exists('foo')->willReturn(false);
        $filesystem->mkdir('foo')->shouldBeCalled();
        $this->createFiles($filesystem);
    }

    function it_skipps_existing_directories(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith(['foo'], []);
        $filesystem->exists('foo')->willReturn(true);
        $filesystem->mkdir('foo')->shouldNotBeCalled();
        $this->createFiles($filesystem);
    }

    function it_creates_files(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith([], ['foo']);
        $filesystem->exists('foo')->willReturn(false);
        $filesystem->writeFile(new Sha256File('foo', ''))->shouldBeCalled();
        $this->createFiles($filesystem);
    }

    function it_skipps_existing_files(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith([], ['foo']);
        $filesystem->exists('foo')->willReturn(true);
        $filesystem->writeFile(Argument::any())->shouldNotBeCalled();
        $this->createFiles($filesystem);
    }
}
