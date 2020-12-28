<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Domain\State;

use byrokrat\giroapp\Domain\State\StateCollection;
use byrokrat\giroapp\Domain\State\StateInterface;
use PhpSpec\ObjectBehavior;

class StateCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(StateCollection::class);
    }

    function it_can_store_states()
    {
        $state = new class () implements StateInterface {
            public static function getStateId(): string
            {
                return 'foobar';
            }

            public function getDescription(): string
            {
                return '';
            }
        };
        $this->addState($state);
        $this->getState('foobar')->shouldReturn($state);
    }
}
