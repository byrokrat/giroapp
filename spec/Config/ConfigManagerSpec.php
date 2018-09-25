<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\RepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ConfigManager::CLASS);
    }

    function it_can_read_configs(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => 'bar']);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturnConfig('bar');
    }

    function it_defaults_configs_to_null(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturnConfig(null);
    }

    function it_merges_configs(RepositoryInterface $repoA, RepositoryInterface $repoB)
    {
        $repoA->getConfigs()->willReturn(['foo' => 'A', 'bar' => 'A']);
        $repoB->getConfigs()->willReturn(['foo' => 'B']);
        $this->loadRepository($repoA);
        $this->loadRepository($repoB);
        $this->getConfig('foo')->shouldReturnConfig('B');
        $this->getConfig('bar')->shouldReturnConfig('A');
    }

    public function getMatchers(): array
    {
        return [
            'returnConfig' => function ($config, $value) {
                return $config->getValue() == $value;
            }
        ];
    }
}
