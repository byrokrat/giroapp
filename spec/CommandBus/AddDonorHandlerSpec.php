<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\AddDonorHandler;
use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorAdded;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\NewDonorProcessor;
use byrokrat\giroapp\Domain\State\StateInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddDonorHandlerSpec extends ObjectBehavior
{
    function let(
        NewDonorProcessor $donorProcessor,
        DonorRepositoryInterface $donorRepository,
        EventDispatcherInterface $dispatcher
    ) {
        $this->beConstructedWith($donorProcessor);
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddDonorHandler::CLASS);
    }

    function it_adds_donors(
        $donorProcessor,
        $donorRepository,
        $dispatcher,
        NewDonor $newDonor,
        Donor $donor
    ) {
        $donor->getPayerNumber()->willReturn('');
        $donor->getMandateKey()->willReturn('');

        $donorProcessor->processNewDonor($newDonor)->willReturn($donor);

        $donorRepository->addNewDonor($donor)->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(DonorAdded::CLASS))->shouldBeCalled();

        $this->handle(new AddDonor($newDonor->getWrappedObject()));
    }
}
