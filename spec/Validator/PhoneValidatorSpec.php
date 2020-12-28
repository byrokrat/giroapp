<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\PhoneValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class PhoneValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PhoneValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', '+46 (0) 70-123 123')->shouldReturn('+46 (0) 70-123 123');
        $this->validate('', '')->shouldReturn('');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::class)->duringValidate('', 'not-a-number');
    }
}
