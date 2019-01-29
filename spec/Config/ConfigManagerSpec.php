<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\RepositoryInterface;
use byrokrat\giroapp\Exception\InvalidConfigException;
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

    function it_can_load_configs_at_construct(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['foo' => 'bar']);
        $this->beConstructedWith($repo);
        $this->getConfig('foo')->shouldReturnConfig('bar');
    }

    function it_defaults_configs_to_empty_string(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([]);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturnConfig('');
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

    function it_resolves_references(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([
            'foo' => '%bar%/%baz%',
            'bar' => 'a',
            'baz' => 'b',
        ]);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturnConfig('a/b');
    }

    function it_resolves_references_recursively(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn([
            'foo' => '%bar%/foo',
            'bar' => '%baz%/bar',
            'baz' => 'baz',
        ]);
        $this->loadRepository($repo);
        $this->getConfig('foo')->shouldReturnConfig('baz/bar/foo');
    }

    function it_throws_on_non_string_value(RepositoryInterface $repo)
    {
        $repo->getConfigs()->willReturn(['no-string' => 123]);
        $this->loadRepository($repo);
        $this->getConfig('no-string')->shouldThrowInvalidConfigException();
    }

    public function getMatchers(): array
    {
        return [
            'returnConfig' => function ($config, $value) {
                return $config->getValue() === $value;
            },
            'throwInvalidConfigException' => function ($config) {
                try {
                    $config->getValue();
                } catch (InvalidConfigException $e) {
                    return true;
                }

                return false;
            },
        ];
    }
}
