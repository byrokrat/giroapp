<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Plugin;

use byrokrat\giroapp\Plugin\PluginCollection;
use byrokrat\giroapp\Plugin\PluginInterface;
use byrokrat\giroapp\Plugin\EnvironmentInterface;
use PhpSpec\ObjectBehavior;

class PluginCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PluginCollection::class);
    }

    function it_loads_plugins(PluginInterface $plugin, EnvironmentInterface $environment)
    {
        $this->beConstructedWith($plugin);
        $plugin->loadPlugin($environment)->shouldBeCalled();
        $this->loadPlugin($environment);
    }
}
