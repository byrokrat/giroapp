<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\EmailValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmailValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EmailValidator::CLASS);
    }

    function it_returns_valid_content()
    {
        $this->validate('', 'test@test.com')->shouldReturn('test@test.com');
        $this->validate('', '')->shouldReturn('');
    }

    function it_throws_on_invalid_content()
    {
        $this->shouldThrow(ValidatorException::CLASS)->duringValidate('', 'not-an-address');
    }
}
