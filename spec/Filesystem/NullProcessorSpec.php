<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Filesystem;

use byrokrat\giroapp\Filesystem\NullProcessor;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NullProcessorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NullProcessor::CLASS);
    }

    function it_passes_file(FileInterface $file)
    {
        $this->processFile($file)->shouldReturn($file);
    }
}
