<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdateStateHandler;
use byrokrat\giroapp\CommandBus\ForceStateHandler;
use byrokrat\giroapp\CommandBus\ForceState;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\Exception\InvalidStateTransitionException;
use Symfony\Component\Workflow\WorkflowInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateStateHandlerSpec extends ObjectBehavior
{
    function let(ForceStateHandler $forceStateHandler, WorkflowInterface $workflow)
    {
        $this->beConstructedWith($forceStateHandler, $workflow);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateStateHandler::CLASS);
    }

    function it_throws_if_change_is_not_allowed($workflow, Donor $donor)
    {
        $workflow->can($donor, 'new-state')->willReturn(false);

        $donor->getMandateKey()->willReturn('');
        $workflow->getEnabledTransitions($donor)->willReturn([]);

        $this->shouldThrow(InvalidStateTransitionException::CLASS)->duringHandle(new UpdateState(
            $donor->getWrappedObject(),
            'new-state'
        ));
    }

    function it_can_change_state($forceStateHandler, $workflow, Donor $donor)
    {
        $workflow->can($donor, 'new-state')->willReturn(true);

        $forceStateHandler->handle(new ForceState($donor->getWrappedObject(), 'new-state'))->shouldBeCalled();

        $this->handle(new UpdateState($donor->getWrappedObject(), 'new-state'));
    }
}
