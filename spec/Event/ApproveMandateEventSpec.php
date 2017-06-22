<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\ApproveMandateEvent;
use Symfony\Component\EventDispatcher\Event;
use byrokrat\autogiro\Tree\Record\Response\MandateResponseNode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApproveMandateEventSpec extends ObjectBehavior
{
    function let(MandateResponseNode $node)
    {
        $this->beConstructedWith($node);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ApproveMandateEvent::CLASS);
    }

    function it_is_an_event()
    {
        $this->shouldHaveType(Event::CLASS);
    }

    function it_contains_a_mandate_response_node(MandateResponseNode $node)
    {
        $this->getNode()->shouldBeLike($node);
    }
}
