<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\RemoveDonorHandler;
use byrokrat\giroapp\CommandBus\RemoveDonor;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorRemoved;
use byrokrat\giroapp\Exception\InvalidStateTransitionException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\Inactive;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RemoveDonorHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveDonorHandler::CLASS);
    }

    function it_throws_on_non_prugeable_donors(Donor $donor, StateInterface $state)
    {
        $donor->getState()->willReturn($state);
        $this->shouldThrow(InvalidStateTransitionException::CLASS)->duringHandle(
            new RemoveDonor($donor->getWrappedObject())
        );
    }

    function it_removes_donors($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getState()->willReturn(new Inactive);
        $donor->getMandateKey()->willReturn('foo');

        $donorRepository->deleteDonor($donor)->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(DonorRemoved::CLASS))->shouldBeCalled();

        $this->handle(new RemoveDonor($donor->getWrappedObject()));
    }
}
