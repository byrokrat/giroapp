<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\RemoveDonorHandler;
use byrokrat\giroapp\CommandBus\RemoveDonor;
use byrokrat\giroapp\CommandBus\ForceRemoveDonor;
use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Workflow\Transitions;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RemoveDonorHandlerSpec extends ObjectBehavior
{
    function let(CommandBusInterface $commandBus)
    {
        $this->setCommandBus($commandBus);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RemoveDonorHandler::CLASS);
    }

    function it_removes_donors($commandBus, Donor $donor)
    {
        $commandBus
            ->handle(new UpdateState($donor->getWrappedObject(), Transitions::REMOVE, 'Donor removed'))
            ->shouldBeCalled();

        $commandBus->handle(new ForceRemoveDonor($donor->getWrappedObject()))->shouldBeCalled();

        $this->handle(new RemoveDonor($donor->getWrappedObject()));
    }
}
