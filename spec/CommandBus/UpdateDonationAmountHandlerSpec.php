<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdateDonationAmountHandler;
use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Workflow\Transitions;
use Money\Money;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateDonationAmountHandlerSpec extends ObjectBehavior
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
        $this->shouldHaveType(UpdateDonationAmountHandler::class);
    }

    function it_ignores_unchanged_data($donorRepository, Donor $donor)
    {
        $donor->getDonationAmount()->willReturn(Money::SEK('100'));
        $donorRepository->updateDonorAmount(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\UpdateDonationAmount($donor->getWrappedObject(), Money::SEK('100'), ''));
    }

    function it_can_change_data($commandBus, $donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->getDonationAmount()->willReturn(Money::SEK('100'));

        $commandBus->handle(
            new CommandBus\UpdateState(
                $donor->getWrappedObject(),
                Transitions::INITIATE_TRANSACTION_UPDATE,
                'desc'
            )
        )->shouldBeCalled();

        $donorRepository->updateDonorAmount($donor, Money::SEK('200'))->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorAmountUpdated::class))
            ->shouldBeCalled();

        $this->handle(new CommandBus\UpdateDonationAmount($donor->getWrappedObject(), Money::SEK('200'), 'desc'));
    }
}
