<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdateDonationAmountHandler;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\amount\Currency\SEK;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateDonationAmountHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateDonationAmountHandler::CLASS);
    }

    function it_ignores_unchanged_data($donorRepository, Donor $donor)
    {
        $donor->getDonationAmount()->willReturn(new SEK('100'));
        $donorRepository->updateDonorAmount(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\UpdateDonationAmount($donor->getWrappedObject(), new SEK('100')));
    }

    function it_can_change_data($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->getDonationAmount()->willReturn(new SEK('100'));

        $donorRepository->updateDonorAmount($donor, new SEK('200'))->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorAmountUpdated::CLASS))
            ->shouldBeCalled();

        $this->handle(new CommandBus\UpdateDonationAmount($donor->getWrappedObject(), new SEK('200')));
    }
}
