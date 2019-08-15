<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdateAttributeHandler;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Domain\Donor;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateAttributeHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateAttributeHandler::class);
    }

    function it_ignores_unchanged_data($donorRepository, Donor $donor)
    {
        $donor->hasAttribute('key')->willReturn(true);
        $donor->getAttribute('key')->willReturn('old');
        $donorRepository->setDonorAttribute(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\UpdateAttribute($donor->getWrappedObject(), 'key', 'old'));
    }

    function it_can_change_data($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->hasAttribute('key')->willReturn(true);
        $donor->getAttribute('key')->willReturn('old');

        $donorRepository->setDonorAttribute($donor, 'key', 'new')->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorAttributeUpdated::class))
            ->shouldBeCalled();

        $this->handle(new CommandBus\UpdateAttribute($donor->getWrappedObject(), 'key', 'new'));
    }
}
