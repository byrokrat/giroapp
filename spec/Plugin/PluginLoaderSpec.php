<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\PluginLoader;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use byrokrat\giroapp\Utils\Filesystem;
use byrokrat\giroapp\Exception\InvalidPluginException;
use Symfony\Component\Finder\Finder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PluginLoaderSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PluginLoader::CLASS);
    }

    function it_fails_on_broken_plugins($filesystem, EnvironmentInterface $environment)
    {
        $filesystem->getFinder()->willReturn((new Finder)->in(__DIR__ . '/brokenplugindata'));

        $this->shouldThrow(InvalidPluginException::CLASS)->during('loadPlugins', [$environment]);
    }

    function it_loads_plugins($filesystem, EnvironmentInterface $environment)
    {
        $filesystem->getFinder()->willReturn((new Finder)->in(__DIR__ . '/validplugindata'));

        $environment->readConfig('custom-test-check')->willReturn('')->shouldBeCalled();

        $this->loadPlugins($environment);
    }
}
