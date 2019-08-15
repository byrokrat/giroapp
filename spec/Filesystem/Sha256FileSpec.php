<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\Sha256File;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;

class Sha256FileSpec extends ObjectBehavior
{
    const FILENAME = 'filename';
    const CONTENT = 'content';

    function let()
    {
        $this->beConstructedWith(self::FILENAME, self::CONTENT);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Sha256File::class);
    }

    function it_is_a_file()
    {
        $this->shouldHaveType(FileInterface::class);
    }

    function it_contains_file_name()
    {
        $this->getFilename()->shouldEqual(self::FILENAME);
    }

    function it_contains_content()
    {
        $this->getContent()->shouldEqual(self::CONTENT);
    }

    function it_can_compute_a_content_hash()
    {
        $this->getChecksum()->shouldEqual(hash('sha256', self::CONTENT));
    }
}
