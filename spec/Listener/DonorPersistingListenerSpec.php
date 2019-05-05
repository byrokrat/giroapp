<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\DonorPersistingListener;
use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorPersistingListenerSpec extends ObjectBehavior
{
    function let(DonorMapper $donorMapper)
    {
        $this->beConstructedWith($donorMapper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorPersistingListener::CLASS);
    }

    function it_creates_new_mandates($donorMapper, DonorEvent $event, Donor $donor)
    {
        $event->getDonor()->willReturn($donor);
        $donorMapper->create($donor)->shouldBeCalled();
        $this->onDonorAdded($event);
    }

    function it_can_update_mandates($donorMapper, DonorEvent $event, Donor $donor)
    {
        $event->getDonor()->willReturn($donor);
        $donorMapper->update($donor)->shouldBeCalled();
        $this->onDonorUpdated($event);
    }

    function it_can_delete_mandates($donorMapper, DonorEvent $event, Donor $donor)
    {
        $event->getDonor()->willReturn($donor);
        $donorMapper->delete($donor)->shouldBeCalled();
        $this->onDonorRemoved($event);
    }
}
