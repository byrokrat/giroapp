<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\ForceStateHandler;
use byrokrat\giroapp\CommandBus\ForceState;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorStateUpdated;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\StateCollection;
use byrokrat\giroapp\Domain\State\StateInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ForceStateHandlerSpec extends ObjectBehavior
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
        $this->shouldHaveType(ForceStateHandler::CLASS);
    }

    function it_can_change_donor_state($stateCollection, $donorRepository, $dispatcher, Donor $donor)
    {
        $oldState = new class() implements StateInterface {
            public static function getStateId(): string
            {
                return 'old-state';
            }

            public function getDescription(): string
            {
            }
        };

        $newState = new class() implements StateInterface {
            public static function getStateId(): string
            {
                return 'new-state';
            }

            public function getDescription(): string
            {
            }
        };

        $donor->getMandateKey()->willReturn('');
        $donor->getState()->willReturn($oldState);

        $stateCollection->getState('new-state')->willReturn($newState);

        $donorRepository->updateDonorState($donor, $newState)->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(DonorStateUpdated::CLASS))->shouldBeCalled();

        $this->handle(new ForceState($donor->getWrappedObject(), 'new-state'));
    }

    function it_ignores_unchanged_states($stateCollection, $donorRepository, Donor $donor)
    {
        $state = new class() implements StateInterface {
            public static function getStateId(): string
            {
                return 'old-state';
            }

            public function getDescription(): string
            {
            }
        };

        $donor->getMandateKey()->willReturn('');
        $donor->getState()->willReturn($state);

        $stateCollection->getState('old-state')->willReturn($state);

        $donorRepository->updateDonorState($donor, $state)->shouldNotBeCalled();

        $this->handle(new ForceState($donor->getWrappedObject(), 'old-state'));
    }
}
