<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Console\Helper\InputReader;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InputReaderSpec extends ObjectBehavior
{
    function let(InputInterface $input, OutputInterface $output, QuestionHelper $questionHelper)
    {
        $this->beConstructedWith($input, $output, $questionHelper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InputReader::CLASS);
    }

    function it_reads_option_if_set($input, Question $question)
    {
        $input->hasOption('option-name')->willReturn(true);
        $input->getOption('option-name')->willReturn('foobar');
        $this->readInput('option-name', $question, 'strtoupper')->shouldReturn('FOOBAR');
    }

    function it_asks_question_if_option_is_not_set($input, $output, $questionHelper, Question $question)
    {
        $input->hasOption('option-name')->willReturn(true);
        $input->getOption('option-name')->willReturn(null);
        $input->isInteractive()->willReturn(true);
        $question->setValidator('strtoupper')->willReturn($question);
        $questionHelper->ask($input, $output, $question)->willReturn('foobar');

        $this->readInput('option-name', $question, 'strtoupper')->shouldReturn('foobar');
    }

    function it_calls_validator_if_non_interactive($input, $output, $questionHelper, Question $question)
    {
        $input->hasOption('option-name')->willReturn(true);
        $input->getOption('option-name')->willReturn(null);
        $input->isInteractive()->willReturn(false);
        $question->setValidator('strtoupper')->willReturn($question);
        $questionHelper->ask($input, $output, $question)->willReturn('foobar');

        $this->readInput('option-name', $question, 'strtoupper')->shouldReturn('FOOBAR');
    }
}
