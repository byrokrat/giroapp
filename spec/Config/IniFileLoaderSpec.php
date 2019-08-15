<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\IniFileLoader;
use byrokrat\giroapp\Config\ConfigManager;
use byrokrat\giroapp\Config\IniRepository;
use byrokrat\giroapp\Filesystem\FilesystemInterface;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IniFileLoaderSpec extends ObjectBehavior
{
    function it_is_initializable(FilesystemInterface $fs)
    {
        $this->beConstructedWith('', $fs);
        $this->shouldHaveType(IniFileLoader::class);
    }

    function it_loads_configs(FilesystemInterface $fs, FileInterface $file, ConfigManager $manager)
    {
        $this->beConstructedWith('foobar', $fs);

        $fs->isFile('foobar')->willReturn(true);
        $fs->readFile('foobar')->willReturn($file);
        $file->getContent()->willReturn('foo=bar');

        $manager->loadRepository(new IniRepository('foo=bar'))->shouldBeCalled();

        $this->loadIniFile($manager);
    }

    function it_fails_on_missing_config_file(FilesystemInterface $fs, ConfigManager $manager)
    {
        $this->beConstructedWith('foobar', $fs);

        $fs->readFile('foobar')->willThrow(\Exception::class);

        $manager->loadRepository(Argument::any())->shouldNotBeCalled();

        $this->shouldThrow(\Exception::class)->during('loadIniFile', [$manager]);
    }
}
