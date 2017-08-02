<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\DI;

use byrokrat\giroapp\DI\UserDirectoryLocator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserDirectoryLocatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserDirectoryLocator::CLASS);
    }

    function it_can_read_option()
    {
        $this->locateUserDirectory('option', 'envPath', '', [], [])->shouldBeLike('option');
    }

    function it_can_read_environment_path()
    {
        $this->locateUserDirectory('', 'envPath', '', [], [])->shouldBeLike('envPath');
    }

    function it_can_read_environment_home()
    {
        $this->locateUserDirectory('', '', 'envHome', [], [])->shouldBeLike('envHome/.giroapp');
    }

    function it_can_read_environment_array_home_index()
    {
        $this->locateUserDirectory('', '', '', ['HOME' => 'foobar'], [])->shouldBeLike('foobar/.giroapp');
    }

    function it_can_read_environment_array_home_index_in_windows_mode()
    {
        $this->locateUserDirectory('', '', '', ['HOMEDRIVE' => 'foo', 'HOMEPATH' => 'bar'], [])
            ->shouldBeLike('foobar/.giroapp');
    }

    function it_can_read_server_array_home_index()
    {
        $this->locateUserDirectory('', '', '', [], ['HOME' => 'foobar'])->shouldBeLike('foobar/.giroapp');
    }

    function it_can_read_server_array_home_index_in_windows_mode()
    {
        $this->locateUserDirectory('', '', '', [], ['HOMEDRIVE' => 'foo', 'HOMEPATH' => 'bar'])
            ->shouldBeLike('foobar/.giroapp');
    }

    function it_uses_fallback_as_a_last_resort()
    {
        $this->beConstructedWith(function () {
            return 'fallback';
        });
        $this->locateUserDirectory('', '', '', [], [])->shouldBeLike('fallback');
    }

    function it_ignores_unknown_array_indices()
    {
        $this->beConstructedWith(function () {
            return 'fallback';
        });
        $this->locateUserDirectory('', '', '', ['ignored' => 'baz'], ['ignored' => 'baz'])->shouldBeLike('fallback');
    }

    function it_has_a_default_fallback_if_ext_posix_is_availiable()
    {
        $this->locateUserDirectory('', '', '', [], [])->shouldMatch('/\.giroapp$/');
    }

    function it_throws_exception_if_directory_is_not_found()
    {
        $this->beConstructedWith(function () {
            return '';
        });
        $this->shouldThrow(\RuntimeException::CLASS)->duringLocateUserDirectory('', '', '', [], []);
    }
}
