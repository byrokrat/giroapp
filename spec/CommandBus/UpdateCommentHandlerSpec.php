<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdateCommentHandler;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Domain\Donor;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateCommentHandlerSpec extends ObjectBehavior
{
    function let(DonorRepositoryInterface $donorRepository, EventDispatcherInterface $dispatcher)
    {
        $this->setDonorRepository($donorRepository);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateCommentHandler::class);
    }

    function it_ignores_unchanged_data($donorRepository, Donor $donor)
    {
        $donor->getComment()->willReturn('old');
        $donorRepository->updateDonorComment(Argument::cetera())->shouldNotBeCalled();
        $this->handle(new CommandBus\UpdateComment($donor->getWrappedObject(), 'old'));
    }

    function it_can_change_data($donorRepository, $dispatcher, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $donor->getComment()->willReturn('old');

        $donorRepository->updateDonorComment($donor, 'new')->shouldBeCalled();

        $dispatcher
            ->dispatch(Argument::type(Event\DonorCommentUpdated::class))
            ->shouldBeCalled();

        $this->handle(new CommandBus\UpdateComment($donor->getWrappedObject(), 'new'));
    }
}
