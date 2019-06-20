<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\RemoveDonorHandler;
use byrokrat\giroapp\CommandBus\RemoveDonor;
use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorRemoved;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\Removed;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RemoveDonorHandlerSpec extends ObjectBehavior
{
    function let(
        CommandBusInterface $commandBus,
        DonorRepositoryInterface $donorRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->setCommandBus($commandBus);
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveDonorHandler::CLASS);
    }

    function it_removes_donors($commandBus, $donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('foo');

        $commandBus->handle(new UpdateState(
            $donor->getWrappedObject(),
            (string)new \byrokrat\giroapp\Utils\ClassIdExtractor(Removed::CLASS)
        ))->shouldBeCalled();


        $donorRepository->deleteDonor($donor)->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(DonorRemoved::CLASS))->shouldBeCalled();

        $this->handle(new RemoveDonor($donor->getWrappedObject()));
    }
}
