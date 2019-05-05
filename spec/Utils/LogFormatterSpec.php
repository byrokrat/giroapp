<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\LogFormatter;
use Apix\Log\LogEntry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LogFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LogFormatter::CLASS);
    }

    function it_formats_log_entries()
    {
        $entry = new LogEntry('error', 'msg', ['key' => 'value']);
        $this->format($entry)->shouldMatch('/\[ERROR\]/');
        $this->format($entry)->shouldMatch('/msg/');
        $this->format($entry)->shouldMatch('/key/');
        $this->format($entry)->shouldMatch('/value/');
    }

    function it_strips_tags()
    {
        $entry = new LogEntry('error', 'this-is-the-<info>logged</info>-message', []);
        $this->format($entry)->shouldMatch('/this-is-the-logged-message/');
    }
}
