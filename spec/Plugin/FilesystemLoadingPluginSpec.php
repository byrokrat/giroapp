<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\FilesystemLoadingPlugin;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Exception\InvalidPluginException;
use Symfony\Component\Finder\Finder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilesystemLoadingPluginSpec extends ObjectBehavior
{
    function let(FilesystemInterface $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilesystemLoadingPlugin::CLASS);
    }

    function it_fails_on_broken_plugins($filesystem, EnvironmentInterface $environment)
    {
        $filesystem->getAbsolutePath('')->willReturn(__DIR__ . '/brokenplugindata');

        $this->shouldThrow(InvalidPluginException::CLASS)->during('loadPlugin', [$environment]);
    }

    function it_loads_plugins($filesystem, EnvironmentInterface $environment)
    {
        $filesystem->getAbsolutePath('')->willReturn(__DIR__ . '/validplugindata');

        $environment->readConfig('custom-test-check')->willReturn('')->shouldBeCalled();

        $this->loadPlugin($environment);
    }
}
