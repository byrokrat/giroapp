<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Console\Helper\QuestionFactory;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
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
        $question = $this->createQuestion('question');
        $question->shouldContainQuestion('question: ');
    }

    function it_creates_questions_with_default_values()
    {
        $question = $this->createQuestion('question', 'def');
        $question->shouldContainQuestion('question [<info>def</info>]: ');
        $question->shouldContainDefault('def');
    }

    function it_creates_choice_questions()
    {
        $question = $this->createChoiceQuestion('question', ['a' => 'foo', 'b' => 'bar'], 'foo');
        $question->shouldContainQuestion('question: ');
        $question->shouldContainDefault('foo');
        $question->shouldContainChoices(['b' => 'bar', 'A' => 'foo']);
    }

    public function getMatchers()
    {
        return [
            'containQuestion' => function (Question $subject, string $question) {
                return $subject->getQuestion() == $question;
            },
            'containDefault' => function (Question $subject, $default) {
                return $subject->getDefault() == $default;
            },
            'containChoices' => function (ChoiceQuestion $subject, array $choices) {
                return $subject->getChoices() == $choices;
            },
        ];
    }
}
