<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Domain;

use byrokrat\giroapp\Domain\FileThatWasImported;
use PhpSpec\ObjectBehavior;

class FileThatWasImportedSpec extends ObjectBehavior
{
    public const FILENAME = 'fname';
    public const CHECKSUM = 'check';

    function let(\DateTimeImmutable $date)
    {
        $this->beConstructedWith(self::FILENAME, self::CHECKSUM, $date);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileThatWasImported::class);
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
