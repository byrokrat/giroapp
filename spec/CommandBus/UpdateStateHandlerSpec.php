<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\UpdateStateHandler;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\Exception\InvalidStateTransitionException;
use Symfony\Component\Workflow\WorkflowInterface;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UpdateStateHandlerSpec extends ObjectBehavior
{
    function let(WorkflowInterface $workflow)
    {
        $this->beConstructedWith($workflow);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UpdateStateHandler::CLASS);
    }

    function it_throws_if_change_is_not_allowed($workflow, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');

        $workflow->can($donor, 'transitionId')->willReturn(false);
        $workflow->getEnabledTransitions($donor)->willReturn([]);

        $this->shouldThrow(InvalidStateTransitionException::CLASS)->duringHandle(new UpdateState(
            $donor->getWrappedObject(),
            'transitionId',
            ''
        ));
    }

    function it_can_change_state($workflow, Donor $donor)
    {
        $workflow->can($donor, 'transitionId')->willReturn(true);

        $workflow->apply($donor, 'transitionId', ['desc' => 'foobar'])->shouldBeCalled();

        $this->handle(new UpdateState($donor->getWrappedObject(), 'transitionId', 'foobar'));
    }
}
