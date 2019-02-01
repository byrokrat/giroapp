<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\PayerNumberValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PayerNumberValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PayerNumberValidator::CLASS);
    }

    function it_returns_valid_content()
    {
        $this->validate('', '123456')->shouldReturn('123456');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::CLASS)->duringValidate('', '12345678901234567');
        $this->shouldThrow(ValidatorException::CLASS)->duringValidate('', 'qwerty');
    }
}
