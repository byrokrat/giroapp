<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\ImportHistoryListener;
use byrokrat\giroapp\Db\ImportHistoryInterface;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImportHistoryListenerSpec extends ObjectBehavior
{
    function let(ImportHistoryInterface $importHistory)
    {
        $this->beConstructedWith($importHistory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportHistoryListener::CLASS);
    }

    function it_adds_to_hsitory($importHistory, FileEvent $event, FileInterface $file)
    {
        $event->getFile()->willReturn($file);
        $importHistory->addToImportHistory($file)->shouldBeCalled();
        $this->onFileImported($event);
    }
}
