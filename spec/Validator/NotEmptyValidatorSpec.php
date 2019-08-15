<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\NotEmptyValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class NotEmptyValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NotEmptyValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', '123')->shouldReturn('123');
    }

    function it_does_not_view_cero_as_empty()
    {
        $this->validate('', '0')->shouldReturn('0');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::class)->duringValidate('', '');
    }
}
