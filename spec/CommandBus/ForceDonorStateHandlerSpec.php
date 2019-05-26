<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\ForceDonorStateHandler;
use byrokrat\giroapp\CommandBus\ForceDonorState;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorStateChanged;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\State\StateInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ForceDonorStateHandlerSpec extends ObjectBehavior
{
    function let(
        StateCollection $stateCollection,
        DonorRepositoryInterface $donorRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->beConstructedWith($stateCollection);
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ForceDonorStateHandler::CLASS);
    }

    function it_can_change_donor_state(
        $stateCollection,
        $donorRepository,
        $dispatcher,
        Donor $donor,
        StateInterface $state
    ) {
        $donor->getMandateKey()->willReturn('');
        $state->getStateId()->willReturn('');

        $stateCollection->getState('state-id')->willReturn($state);

        $donorRepository->updateDonorState($donor, $state)->shouldBeCalled();
        $dispatcher->dispatch(DonorStateChanged::CLASS, Argument::type(DonorStateChanged::CLASS))->shouldBeCalled();

        $this->handle(new ForceDonorState($donor->getWrappedObject(), 'state-id'));
    }
}
