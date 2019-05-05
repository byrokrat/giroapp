<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\BaseDirReader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseDirReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('');
        $this->shouldHaveType(BaseDirReader::CLASS);
    }

    function it_finds_base_dir()
    {
        $this->beConstructedWith(__FILE__);
        $this->getBaseDir()->shouldReturn(__DIR__);
    }

    function it_finds_base_dir_for_cwd()
    {
        $this->beConstructedWith('giroapp.ini');
        $this->getBaseDir()->shouldReturn('.');
    }
}
