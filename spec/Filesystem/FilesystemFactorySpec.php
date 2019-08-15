<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\FilesystemFactory;
use byrokrat\giroapp\Filesystem\NullFilesystem;
use byrokrat\giroapp\Filesystem\StdFilesystem;
use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;
use PhpSpec\ObjectBehavior;

class FilesystemFactorySpec extends ObjectBehavior
{
    function let(SymfonyFilesystem $fs)
    {
        $this->beConstructedWith($fs);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemFactory::class);
    }

    function it_can_create_null_filesystems()
    {
        $this->createFilesystem('')->shouldBeLike(new NullFilesystem);
    }

    function it_can_create_std_filesystems($fs)
    {
        $this->createFilesystem('path')->shouldBeLike(new StdFilesystem('path', $fs->getWrappedObject()));
    }
}
