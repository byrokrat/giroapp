<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\IniFileLoader;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\IniRepository;
use byrokrat\giroapp\Utils\Filesystem;
use byrokrat\giroapp\Utils\File;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IniFileLoaderSpec extends ObjectBehavior
{
    function it_is_initializable(Filesystem $fs)
    {
        $this->beConstructedWith('', $fs);
        $this->shouldHaveType(IniFileLoader::CLASS);
    }

    function it_loads_configs(Filesystem $fs, File $file, ConfigManager $manager)
    {
        $this->beConstructedWith('foobar', $fs);

        $fs->isFile('foobar')->willReturn(true);
        $fs->readFile('foobar')->willReturn($file);
        $file->getContent()->willReturn('foo=bar');

        $manager->loadRepository(new IniRepository('foo=bar'))->shouldBeCalled();

        $this->loadIniFile($manager);
    }

    function it_ignores_non_existing_files(Filesystem $fs, ConfigManager $manager)
    {
        $this->beConstructedWith('foobar', $fs);

        $fs->isFile('foobar')->willReturn(false);

        $manager->loadRepository(Argument::any())->shouldNotBeCalled();

        $this->loadIniFile($manager);
    }
}
