<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Console\Helper\QuestionFactory;
use Symfony\Component\Console\Question\Question;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class QuestionFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(QuestionFactory::CLASS);
    }

    function it_creates_simple_questions()
    {
        $this->createQuestion('question')->shouldBeLike(new Question('question: '));
    }

    function it_creates_questions_with_default_values()
    {
        $this->createQuestion('question', 'def')->shouldBeLike(new Question('question [def]: ', 'def'));
    }
}
