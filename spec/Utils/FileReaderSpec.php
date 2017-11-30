<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\FileReader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FileReader::CLASS);
    }

    function it_fails_if_file_does_not_exist()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringSetFilename('does-not-exist');
    }

    function it_fails_if_no_file_is_set()
    {
        $this->shouldThrow(\RuntimeException::CLASS)->duringGetContents();
    }

    function it_can_read_content()
    {
        $this->setFilename(__FILE__);
        $this->getContents()->shouldMatch('/it_can_read_content/');
    }

    function it_can_set_name_during_construct()
    {
        $this->beConstructedWith(__FILE__);
        $this->getContents()->shouldMatch('/it_can_read_content/');
    }
}
