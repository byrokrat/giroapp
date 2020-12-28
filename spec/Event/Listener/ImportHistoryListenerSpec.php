<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\Listener\ImportHistoryListener;
use byrokrat\giroapp\Db\ImportHistoryInterface;
use byrokrat\giroapp\Event\FileImported;
use byrokrat\giroapp\Filesystem\FileInterface;
use PhpSpec\ObjectBehavior;

class ImportHistoryListenerSpec extends ObjectBehavior
{
    function let(ImportHistoryInterface $importHistory)
    {
        $this->beConstructedWith($importHistory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ImportHistoryListener::class);
    }

    function it_adds_to_hsitory($importHistory, FileImported $event, FileInterface $file)
    {
        $event->getFile()->willReturn($file);
        $importHistory->addToImportHistory($file)->shouldBeCalled();
        $this->__invoke($event);
    }
}
