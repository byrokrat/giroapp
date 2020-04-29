<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\RemoveAttributeHandler;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Domain\Donor;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RemoveAttributeHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveAttributeHandler::class);
    }

    function it_ignores_non_existing_attr($donorRepository, Donor $donor)
    {
        $donor->hasAttribute('key')->willReturn(false);
        $donorRepository->deleteDonorAttribute(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\RemoveAttribute($donor->getWrappedObject(), 'key'));
    }

    function it_removes_attr($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->hasAttribute('key')->willReturn(true);

        $donorRepository->deleteDonorAttribute($donor, 'key')->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorAttributeRemoved::class))
            ->shouldBeCalled();

        $this->handle(new CommandBus\RemoveAttribute($donor->getWrappedObject(), 'key'));
    }
}
