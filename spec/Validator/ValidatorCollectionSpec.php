<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Validator;

use byrokrat\giroapp\Validator\ValidatorCollection;
use byrokrat\giroapp\Validator\ValidatorInterface;
use byrokrat\giroapp\Exception\ValidatorException;
use PhpSpec\ObjectBehavior;

class ValidatorCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ValidatorCollection::class);
    }

    function it_returns_valid_content(ValidatorInterface $validator)
    {
        $this->beConstructedWith($validator);
        $validator->validate('a', 'b')->willReturn('c');
        $this->validate('a', 'b')->shouldReturn('c');
    }

    function it_links_validators(ValidatorInterface $validatorA, ValidatorInterface $validatorB)
    {
        $this->beConstructedWith($validatorA, $validatorB);
        $validatorA->validate('a', 'b')->willReturn('c');
        $validatorB->validate('a', 'c')->willReturn('d');
        $this->validate('a', 'b')->shouldReturn('d');
    }

    function it_throws_when_validator_throws(ValidatorInterface $validator)
    {
        $this->beConstructedWith($validator);
        $validator->validate('a', 'b')->willThrow(ValidatorException::class);
        $this->shouldThrow(ValidatorException::class)->duringValidate('a', 'b');
    }
}
