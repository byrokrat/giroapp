<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\CallbackValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CallbackValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('ctype_digit');
        $this->shouldHaveType(CallbackValidator::CLASS);
    }

    function it_returns_callback_content()
    {
        $this->beConstructedWith(function (string $value) {
            return strtoupper($value);
        });
        $this->validate('a', 'b')->shouldReturn('B');
    }

    function it_returns_string_on_other_scalar()
    {
        $this->beConstructedWith(function (string $value) {
            return null;
        });
        $this->validate('a', 'b')->shouldReturn('');
    }

    function it_throws_if_return_value_can_not_be_cast_to_string()
    {
        $this->beConstructedWith(function (string $value) {
            return [];
        });
        $this->shouldThrow(\LogicException::CLASS)->duringValidate('', '');
    }

    function it_throws_when_validator_throws()
    {
        $this->beConstructedWith(function (string $value) {
            throw new \Exception;
        });
        $this->shouldThrow(ValidatorException::CLASS)->duringValidate('', '');
    }
}
