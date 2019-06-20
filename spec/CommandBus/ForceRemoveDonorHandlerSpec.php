<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\ForceRemoveDonorHandler;
use byrokrat\giroapp\CommandBus\ForceRemoveDonor;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event\DonorRemoved;
use byrokrat\giroapp\Domain\Donor;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ForceRemoveDonorHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ForceRemoveDonorHandler::CLASS);
    }

    function it_removes_donors($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('foo');

        $donorRepository->deleteDonor($donor)->shouldBeCalled();
        $dispatcher->dispatch(Argument::type(DonorRemoved::CLASS))->shouldBeCalled();

        $this->handle(new ForceRemoveDonor($donor->getWrappedObject()));
    }
}
