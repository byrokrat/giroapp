<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\File;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileSpec extends ObjectBehavior
{
    const FILENAME = 'filename';
    const CONTENT = 'content';

    function let()
    {
        $this->beConstructedWith(self::FILENAME, self::CONTENT);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(File::CLASS);
    }

    function it_contains_file_name()
    {
        $this->getFilename()->shouldEqual(self::FILENAME);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldEqual(self::CONTENT);
    }
}
