<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\IdValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class IdValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(IdValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', '123')->shouldReturn('123');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::class)->duringValidate('', 'abc');
    }
}
