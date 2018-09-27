<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\FilesystemConfigurator;
use byrokrat\giroapp\Filesystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemConfiguratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemConfigurator::CLASS);
    }

    function it_creates_dir_if_does_not_exist(Filesystem $fs)
    {
        $fs->exists('')->willReturn(false);
        $fs->mkdir('')->shouldBeCalled();
        $this->createCurrentDirectory($fs);
    }
}
