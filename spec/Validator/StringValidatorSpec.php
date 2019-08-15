<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\StringValidator;
use PhpSpec\ObjectBehavior;

class StringValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StringValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', chr(1) . 'foobar')->shouldReturn('foobar');
        $this->validate('', 'åäö')->shouldReturn('åäö');
        $this->validate('', '')->shouldReturn('');
    }
}
