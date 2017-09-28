<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp;

use byrokrat\giroapp\ApplicationMonitor;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\LogEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationMonitorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ApplicationMonitor::CLASS);
    }

    function it_is_an_event_subscriber()
    {
        $this->shouldHaveType(EventSubscriberInterface::CLASS);
    }

    function it_listens_import_events()
    {
        $this->getSubscribedEvents()->shouldHaveKeyWithValue(Events::IMPORT_EVENT, ['dispatchInfo', 10]);
    }

    function it_listens_to_add_mandate_events()
    {
        $this->getSubscribedEvents()->shouldHaveKeyWithValue(Events::MANDATE_ADDED_EVENT, ['dispatchInfo', 10]);
    }

    function it_listens_to_edit_mandate_events()
    {
        $this->getSubscribedEvents()->shouldHaveKeyWithValue(Events::MANDATE_EDITED_EVENT, ['dispatchInfo', 10]);
    }

    function it_listens_to_approved_mandate_events()
    {
        $this->getSubscribedEvents()->shouldHaveKeyWithValue(Events::MANDATE_APPROVED_EVENT, ['dispatchInfo', 10]);
    }

    function it_listens_to_revoked_mandate_events()
    {
        $this->getSubscribedEvents()->shouldHaveKeyWithValue(Events::MANDATE_REVOKED_EVENT, ['dispatchInfo', 10]);
    }

    function it_listens_to_dropped_mandate_events()
    {
        $this->getSubscribedEvents()->shouldHaveKeyWithValue(Events::MANDATE_DROPPED_EVENT, ['dispatchInfo', 10]);
    }

    function it_listens_to_invalid_mandate_events()
    {
        $this->getSubscribedEvents()->shouldHaveKeyWithValue(Events::MANDATE_INVALID_EVENT, ['dispatchWarning', 10]);
    }

    function it_dispatches_info(LogEvent $event, EventDispatcherInterface $dispatcher)
    {
        $this->dispatchInfo($event, '', $dispatcher);
        $dispatcher->dispatch(Events::INFO_EVENT, $event)->shouldHaveBeenCalled();
    }

    function it_dispatches_warning(LogEvent $event, EventDispatcherInterface $dispatcher)
    {
        $this->dispatchWarning($event, '', $dispatcher);
        $dispatcher->dispatch(Events::WARNING_EVENT, $event)->shouldHaveBeenCalled();
    }
}
