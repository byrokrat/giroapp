<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdateNameHandler;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Model\Donor;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateNameHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateNameHandler::CLASS);
    }

    function it_ignores_unchanged_data($donorRepository, Donor $donor)
    {
        $donor->getName()->willReturn('old');
        $donorRepository->updateDonorName(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\UpdateName($donor->getWrappedObject(), 'old'));
    }

    function it_can_change_data($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->getName()->willReturn('old');

        $donorRepository->updateDonorName($donor, 'new')->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorNameUpdated::CLASS))
            ->shouldBeCalled();

        $this->handle(new CommandBus\UpdateName($donor->getWrappedObject(), 'new'));
    }
}
