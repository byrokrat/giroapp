<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdatePhoneHandler;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Model\Donor;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdatePhoneHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdatePhoneHandler::CLASS);
    }

    function it_ignores_unchanged_data($donorRepository, Donor $donor)
    {
        $donor->getPhone()->willReturn('old');
        $donorRepository->updateDonorPhone(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\UpdatePhone($donor->getWrappedObject(), 'old'));
    }

    function it_can_change_data($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->getPhone()->willReturn('old');

        $donorRepository->updateDonorPhone($donor, 'new')->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorPhoneUpdated::CLASS))
            ->shouldBeCalled();

        $this->handle(new CommandBus\UpdatePhone($donor->getWrappedObject(), 'new'));
    }
}
