<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\Listener\DonorStateListener;
use byrokrat\giroapp\Event\DonorStateUpdated;
use byrokrat\giroapp\State\StateInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorStateListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('state-id', 'is_string');
        $this->shouldHaveType(DonorStateListener::CLASS);
    }

    function it_ignores_unknown_states(DonorStateUpdated $event, StateInterface $state)
    {
        $event->getNewState()->willReturn($state);
        $state->getStateId()->willReturn('foo');

        $called = false;
        $this->beConstructedWith('not-foo-id', function () use (&$called) {
            $called = true;
        });

        $this->__invoke($event);

        if ($called) {
            throw new \Exception('Listener should not have been called');
        }
    }

    function it_calls_listener_on_id_match(DonorStateUpdated $event, StateInterface $state)
    {
        $event->getNewState()->willReturn($state);
        $state->getStateId()->willReturn('foo');

        $called = false;
        $this->beConstructedWith('foo', function () use (&$called) {
            $called = true;
        });

        $this->__invoke($event);

        if (!$called) {
            throw new \Exception('Listener should have been called');
        }
    }

    function it_calls_listener_on_implements_match(DonorStateUpdated $event, StateInterface $state)
    {
        $event->getNewState()->willReturn($state);
        $state->getStateId()->willReturn('foo');

        $called = false;
        $this->beConstructedWith(StateInterface::CLASS, function () use (&$called) {
            $called = true;
        });

        $this->__invoke($event);

        if (!$called) {
            throw new \Exception('Listener should have been called');
        }
    }
}
