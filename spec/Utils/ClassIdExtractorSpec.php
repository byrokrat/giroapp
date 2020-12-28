<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\ClassIdExtractor;
use PhpSpec\ObjectBehavior;

class ClassIdExtractorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(self::class);
        $this->shouldHaveType(ClassIdExtractor::class);
    }

    function it_can_extract_from_class_name()
    {
        $this->beConstructedWith(ClassIdExtractor::class);
        $this->__toString()->shouldReturn('CLASS_ID_EXTRACTOR');
    }

    function it_can_extract_from_object()
    {
        $this->beConstructedWith(new ClassIdExtractor(ClassIdExtractor::class));
        $this->__toString()->shouldReturn('CLASS_ID_EXTRACTOR');
    }
}
