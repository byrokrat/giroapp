<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\LogFormatter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LogFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LogFormatter::CLASS);
    }

    function it_doesnt_care_about_decoding()
    {
        $this->decode('some-string-value')->shouldEqual([]);
    }

    function it_encodes_log_documents()
    {
        $doc = [
            'message' => 'this-is-the-logged-message',
            'severity' => 'ERROR',
            'context' => ['some-key' => 'some-value']
        ];

        $this->encode($doc)->shouldMatch('/this-is-the-logged-message/');
        $this->encode($doc)->shouldMatch('/\[ERROR\]/');
        $this->encode($doc)->shouldMatch('/some-key/');
        $this->encode($doc)->shouldMatch('/some-value/');
    }

    function it_strips_tags()
    {
        $doc = [
            'message' => 'this-is-the-<info>logged</info>-message',
            'severity' => 'ERROR',
            'context' => []
        ];

        $this->encode($doc)->shouldMatch('/this-is-the-logged-message/');
    }
}
