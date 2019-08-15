<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\AccountValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class AccountValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AccountValidator::class);
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
