<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp;

use byrokrat\giroapp\FilesystemConfigurator;
use League\Flysystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemConfiguratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(['foo', 'bar']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemConfigurator::CLASS);
    }

    function it_creates_files(Filesystem $filesystem)
    {
        $filesystem->has('foo')->willReturn(false)->shouldBeCalled();
        $filesystem->has('bar')->willReturn(true)->shouldBeCalled();
        $filesystem->write('foo', '')->shouldBeCalled();
        $this->createFiles($filesystem);
    }
}