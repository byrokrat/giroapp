<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\StateCollection;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\giroapp\Domain\State\Error;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StateCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StateCollection::CLASS);
    }

    function it_can_get_by_id(StateInterface $state)
    {
        $state->getStateId()->willReturn('foobar');
        $this->addState($state);
        $this->getState('foobar')->shouldReturn($state);
    }

    function it_can_get_by_class_name()
    {
        $error = new Error;
        $this->addState($error);
        $this->getState(Error::CLASS)->shouldReturn($error);
    }
}
