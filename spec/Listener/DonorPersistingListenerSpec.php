<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\DonorPersistingListener;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorPersistingListenerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository)
    {
        $this->beConstructedWith($donorRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorPersistingListener::CLASS);
    }

    function it_creates_new_mandates($donorRepository, DonorEvent $event, Donor $donor)
    {
        $event->getDonor()->willReturn($donor);
        $donorRepository->addNewDonor($donor)->shouldBeCalled();
        $this->onDonorAdded($event);
    }

    function it_can_update_mandates($donorRepository, DonorEvent $event, Donor $donor)
    {
        $event->getDonor()->willReturn($donor);
        $donor->getName()->willReturn('name');
        $donorRepository->updateDonorName($donor, 'name')->shouldBeCalled();
        $this->onDonorUpdated($event);
    }

    function it_can_delete_mandates($donorRepository, DonorEvent $event, Donor $donor)
    {
        $event->getDonor()->willReturn($donor);
        $donorRepository->deleteDonor($donor)->shouldBeCalled();
        $this->onDonorRemoved($event);
    }
}
