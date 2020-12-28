<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\DefaultsReader;
use PhpSpec\ObjectBehavior;

class DefaultsReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DefaultsReader::class);
    }

    function it_reads_defaults()
    {
        $this->getRawDefaults()->shouldBeString();
    }
}
