<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\NumericValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class NumericValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NumericValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', '123')->shouldReturn('123');
        $this->validate('', '')->shouldReturn('');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::class)->duringValidate('', '123.12');
    }
}
