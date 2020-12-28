<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\EmailValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class EmailValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EmailValidator::class);
    }

    function it_returns_valid_content()
    {
        $this->validate('', 'test@test.com')->shouldReturn('test@test.com');
        $this->validate('', '')->shouldReturn('');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::class)->duringValidate('', 'not-an-address');
    }
}
