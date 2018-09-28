<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\HashedFile;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HashedFileSpec extends ObjectBehavior
{
    const FILENAME = 'filename';
    const CONTENT = 'content';
    const HASH = 'hash';

    function let()
    {
        $this->beConstructedWith(self::FILENAME, self::CONTENT, self::HASH);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HashedFile::CLASS);
    }

    function it_is_a_file()
    {
        $this->shouldHaveType(FileInterface::CLASS);
    }

    function it_contains_file_name()
    {
        $this->getFilename()->shouldEqual(self::FILENAME);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldEqual(self::CONTENT);
    }

    function it_contains_hash()
    {
        $this->getChecksum()->shouldEqual(self::HASH);
    }
}
