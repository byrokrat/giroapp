<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Model;

use byrokrat\giroapp\Model\FileThatWasImported;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileThatWasImportedSpec extends ObjectBehavior
{
    const FILENAME = 'fname';
    const CHECKSUM = 'check';

    function let(\DateTimeImmutable $date)
    {
        $this->beConstructedWith(self::FILENAME, self::CHECKSUM, $date);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileThatWasImported::CLASS);
    }

    function it_contains_a_filename()
    {
        $this->getFilename()->shouldReturn(self::FILENAME);
    }

    function it_contains_a_checksum()
    {
        $this->getChecksum()->shouldReturn(self::CHECKSUM);
    }

    function it_contains_a_datetime($date)
    {
        $this->getDatetime()->shouldReturn($date);
    }
}
