<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\IniRepository;
use byrokrat\giroapp\Config\RepositoryInterface;
use byrokrat\giroapp\Exception\InvalidConfigException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IniRepositorySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(IniRepository::CLASS);
    }

    function it_is_a_repository()
    {
        $this->shouldHaveType(RepositoryInterface::CLASS);
    }

    function it_contains_configs()
    {
        $this->beConstructedWith('foo = bar');
        $this->getConfigs()->shouldReturn(['foo' => 'bar']);
    }

    function it_fails_on_invalid_ini_string()
    {
        $this->beConstructedWith('null = null');
        $this->shouldThrow(InvalidConfigException::CLASS)->duringInstantiation();
    }
}
