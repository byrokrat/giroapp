<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\PhoneValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhoneValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PhoneValidator::CLASS);
    }

    function it_returns_valid_content()
    {
        $this->validate('', '+46 (0) 70-123 123')->shouldReturn('+46 (0) 70-123 123');
        $this->validate('', '')->shouldReturn('');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::CLASS)->duringValidate('', 'not-a-number');
    }
}
