<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\StringValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StringValidator::CLASS);
    }

    function it_returns_valid_content()
    {
        $this->validate('', chr(1) . 'foobar')->shouldReturn('foobar');
        $this->validate('', 'åäö')->shouldReturn('åäö');
        $this->validate('', '')->shouldReturn('');
    }
}
