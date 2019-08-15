<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\DonorKeyValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class DonorKeyValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DonorKeyValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', 'dhHjduey67839287')->shouldReturn('dhHjduey67839287');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::class)->duringValidate('key', 'a.a');
    }
}
