<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdatePostalAddressHandler;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdatePostalAddressHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdatePostalAddressHandler::CLASS);
    }

    function it_ignores_unchanged_data($donorRepository, Donor $donor)
    {
        $donor->getPostalAddress()->willReturn(new PostalAddress('old'));
        $donorRepository->updateDonorAddress(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\UpdatePostalAddress($donor->getWrappedObject(), new PostalAddress('old')));
    }

    function it_can_change_data($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->getPostalAddress()->willReturn(new PostalAddress('old'));

        $donorRepository->updateDonorAddress($donor, new PostalAddress('new'))->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorPostalAddressUpdated::CLASS))
            ->shouldBeCalled();

        $this->handle(new CommandBus\UpdatePostalAddress($donor->getWrappedObject(), new PostalAddress('new')));
    }
}
