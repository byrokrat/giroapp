<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp;

use byrokrat\giroapp\AutogiroVisitor;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\autogiro\Tree\Node;
use byrokrat\banking\Bankgiro;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutogiroVisitorSpec extends ObjectBehavior
{
    const ORG_BGC_NR = 'foobar';

    function let(Dispatcher $dispatcher, Bankgiro $orgBg)
    {
        $this->beConstructedWith(self::ORG_BGC_NR, $orgBg);
        $this->setEventDispatcher($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AutogiroVisitor::CLASS);
    }

    function it_is_a_visitor()
    {
        $this->shouldHaveType(Visitor::CLASS);
    }

    function it_dispatches_on_mandate_response_node($dispatcher, Node $node)
    {
        $event = new NodeEvent($node->getWrappedObject());
        $dispatcher->dispatch(Events::MANDATE_RESPONSE_RECEIVED, $event)->shouldBeCalled();
        $this->beforeMandateResponse($node);
    }

    function it_throws_on_invalid_bg_in_opening_node($orgBg, Node $node, Bankgiro $payeeBg)
    {
        $node->getChild('PayeeBgcNumber')->willReturn($node);
        $node->getValue()->willReturn(self::ORG_BGC_NR);
        $node->getChild('PayeeBankgiro')->willReturn($node);
        $node->getValueFrom('Object')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(false);
        $this->shouldThrow(\RuntimeException::CLASS)->during('beforeOpening', [$node]);
    }

    function it_throws_on_invalid_bgc_nr_in_opening_node($orgBg, Node $node, Bankgiro $payeeBg)
    {
        $node->getChild('PayeeBgcNumber')->willReturn($node);
        $node->getValue()->willReturn('some-invalid-value');
        $node->getChild('PayeeBankgiro')->willReturn($node);
        $node->getValueFrom('Object')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(true);
        $this->shouldThrow(\RuntimeException::CLASS)->during('beforeOpening', [$node]);
    }
}
