<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\DonorPersistingListener;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\Amount\Currency\SEK;
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

    function it_can_update_mandates(
        $donorRepository,
        DonorEvent $event,
        Donor $donor,
        StateInterface $state,
        PostalAddress $address
    ) {
        $amount = new SEK('100');

        $event->getDonor()->willReturn($donor);

        $donor->getName()->willReturn('name');
        $donor->getState()->willReturn($state);
        $donor->getPayerNumber()->willReturn('p-nr');
        $donor->getDonationAmount()->willReturn($amount);
        $donor->getPostalAddress()->willReturn($address);
        $donor->getEmail()->willReturn('mail');
        $donor->getPhone()->willReturn('phone');
        $donor->getComment()->willReturn('comment');
        $donor->getAttributes()->willReturn([]);

        $donorRepository->updateDonorName($donor, 'name')->shouldBeCalled();
        $donorRepository->updateDonorState($donor, $state)->shouldBeCalled();
        $donorRepository->updateDonorPayerNumber($donor, 'p-nr')->shouldBeCalled();
        $donorRepository->updateDonorAmount($donor, $amount)->shouldBeCalled();
        $donorRepository->updateDonorAddress($donor, $address)->shouldBeCalled();
        $donorRepository->updateDonorEmail($donor, 'mail')->shouldBeCalled();
        $donorRepository->updateDonorPhone($donor, 'phone')->shouldBeCalled();
        $donorRepository->updateDonorComment($donor, 'comment')->shouldBeCalled();

        $this->onDonorUpdated($event);
    }

    function it_can_delete_mandates($donorRepository, DonorEvent $event, Donor $donor)
    {
        $event->getDonor()->willReturn($donor);
        $donorRepository->deleteDonor($donor)->shouldBeCalled();
        $this->onDonorRemoved($event);
    }
}
