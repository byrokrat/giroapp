<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\AttemptStateHandler;
use byrokrat\giroapp\CommandBus\AttemptState;
use byrokrat\giroapp\CommandBus\UpdateStateHandler;
use byrokrat\giroapp\CommandBus\UpdateState;
use Symfony\Component\Workflow\WorkflowInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AttemptStateHandlerSpec extends ObjectBehavior
{
    function let(UpdateStateHandler $updateStateHandler, WorkflowInterface $workflow)
    {
        $this->beConstructedWith($updateStateHandler, $workflow);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AttemptStateHandler::class);
    }

    function it_does_nothing_if_change_is_not_allowed($updateStateHandler, $workflow, Donor $donor)
    {
        $workflow->can($donor, 'transitionId')->willReturn(false);

        $updateStateHandler->handle(Argument::any())->shouldNotBeCalled();

        $this->handle(new AttemptState($donor->getWrappedObject(), 'transitionId', ''));
    }

    function it_can_change_state($updateStateHandler, $workflow, Donor $donor)
    {
        $workflow->can($donor, 'transitionId')->willReturn(true);

        $updateStateHandler->handle(
            new UpdateState($donor->getWrappedObject(), 'transitionId', 'foobar')
        )->shouldBeCalled();

        $this->handle(new AttemptState($donor->getWrappedObject(), 'transitionId', 'foobar'));
    }
}
