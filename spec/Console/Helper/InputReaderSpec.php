<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Console\Helper\InputReader;
use byrokrat\giroapp\Validator\ValidatorInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\Question;
use PhpSpec\ObjectBehavior;

class InputReaderSpec extends ObjectBehavior
{
    function let(InputInterface $input, OutputInterface $output)
    {
        $this->beConstructedWith($input, $output, new QuestionHelper());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InputReader::class);
    }

    function it_reads_option_if_set($input, ValidatorInterface $validator)
    {
        $input->hasOption('key')->willReturn(true);
        $input->getOption('key')->willReturn('foo');
        $validator->validate('key', 'foo')->willReturn('bar');
        $this->readInput('key', new Question(''), $validator)->shouldReturn('bar');
    }

    function it_asks_question_interactively($input, $output, ValidatorInterface $validator)
    {
        $input->hasOption('key')->willReturn(true);
        $input->getOption('key')->willReturn('');
        $input->isInteractive()->willReturn(true);
        $validator->validate('key', '')->willReturn('foobar')->shouldBeCalled();
        $this->readInput('key', new Question(''), $validator)->shouldReturn('foobar');
    }

    function it_reads_question_default($input, $output, ValidatorInterface $validator)
    {
        $input->hasOption('key')->willReturn(true);
        $input->getOption('key')->willReturn(null);
        $input->isInteractive()->willReturn(false);
        $question = new Question('', 'default');
        $validator->validate('key', 'default')->willReturn('foobar')->shouldBeCalled();
        $validator->validate('key', 'foobar')->willReturn('foobar');
        $this->readInput('key', $question, $validator)->shouldReturn('foobar');
    }

    function it_asks_question_non_interactively($input, $output, ValidatorInterface $validator)
    {
        $input->hasOption('key')->willReturn(true);
        $input->getOption('key')->willReturn(null);
        $input->isInteractive()->willReturn(false);
        $validator->validate('key', '')->willReturn('foobar')->shouldBeCalled();
        $this->readInput('key', new Question(''), $validator)->shouldReturn('foobar');
    }
}
