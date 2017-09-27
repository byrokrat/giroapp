<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\MandatePersistingListener;
use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\id\Id;
use byrokrat\banking\AccountNumber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MandatePersistingListenerSpec extends ObjectBehavior
{
    function let(DonorMapper $donorMapper)
    {
        $this->beConstructedWith($donorMapper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MandatePersistingListener::CLASS);
    }

    function it_fails_if_mandate_exists(
        $donorMapper,
        DonorEvent $event,
        Donor $donor,
        Id $id,
        AccountNumber $account,
        EventDispatcherInterface $dispatcher
    ) {
        $event->getDonor()->willReturn($donor);
        $event->stopPropagation()->shouldBeCalled();

        $donor->getMandateKey()->willReturn('foobar');
        $donorMapper->hasKey('foobar')->willReturn(true);

        $id->format('S-sk')->willReturn('');
        $account->getNumber()->willReturn('');

        $donor->getDonorId()->willReturn($id);
        $donor->getAccount()->willReturn($account);

        $dispatcher->dispatch(Events::WARNING_EVENT, Argument::type(LogEvent::CLASS))->shouldBeCalled();

        $this->onMandateAddedEvent($event, '', $dispatcher);
    }

    function it_saves_new_mandates(
        $donorMapper,
        DonorEvent $event,
        Donor $donor,
        EventDispatcherInterface $dispatcher
    ) {
        $event->getDonor()->willReturn($donor);

        $donor->getMandateKey()->willReturn('foobar');
        $donorMapper->hasKey('foobar')->willReturn(false);

        $donorMapper->save($donor)->shouldBeCalled();

        $this->onMandateAddedEvent($event, '', $dispatcher);
    }
}
