<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\BgcNumberValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class BgcNumberValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BgcNumberValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', '123456')->shouldReturn('123456');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::class)->duringValidate('', '123');
        $this->shouldThrow(ValidatorException::class)->duringValidate('', 'qwerty');
    }
}
