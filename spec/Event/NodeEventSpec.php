<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\NodeEvent;
use Symfony\Component\EventDispatcher\Event;
use byrokrat\autogiro\Tree\Node;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NodeEventSpec extends ObjectBehavior
{
    function let(Node $node)
    {
        $this->beConstructedWith($node);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NodeEvent::CLASS);
    }

    function it_is_an_event()
    {
        $this->shouldHaveType(Event::CLASS);
    }

    function it_contains_a_mandate_response_node(Node $node)
    {
        $this->getNode()->shouldBeLike($node);
    }
}
