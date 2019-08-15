<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\ChoiceValidator;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class ChoiceValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith([]);
        $this->shouldHaveType(ChoiceValidator::class);
    }

    function it_returns_valid_value_associated_with_key()
    {
        $this->beConstructedWith(['key' => 'value']);
        $this->validate('', 'key')->shouldReturn('value');
    }

    function it_is_case_insensitive_for_keys()
    {
        $this->beConstructedWith(['key' => 'value']);
        $this->validate('', 'KEY')->shouldReturn('value');
    }

    function it_returns_value_if_valid()
    {
        $this->beConstructedWith(['key' => 'value']);
        $this->validate('', 'value')->shouldReturn('value');
    }

    function it_throws_on_invalid_content()
    {
        $this->beConstructedWith([]);
        $this->shouldThrow(ValidatorException::class)->duringValidate('', 'not-defined');
    }
}
