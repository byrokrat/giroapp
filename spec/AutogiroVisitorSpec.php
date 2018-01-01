<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp;

use byrokrat\giroapp\AutogiroVisitor;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\autogiro\Tree\Record\OpeningRecordNode;
use byrokrat\autogiro\Tree\Record\Request\RequestOpeningRecordNode;
use byrokrat\autogiro\Tree\Record\Response\MandateResponseNode;
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

    function it_dispatches_on_mandate_response_node($dispatcher, MandateResponseNode $node)
    {
        $event = new NodeEvent($node->getWrappedObject());
        $dispatcher->dispatch(Events::MANDATE_RESPONSE_RECEIVED, $event)->shouldBeCalled();
        $this->beforeMandateResponseNode($node);
    }

    function it_throws_on_invalid_bg_in_opening_node($orgBg, OpeningRecordNode $node, Bankgiro $payeeBg)
    {
        $node->getChild('payee_bgc_number')->willReturn($node);
        $node->getValue()->willReturn(self::ORG_BGC_NR);
        $node->getChild('payee_bankgiro')->willReturn($node);
        $node->getAttribute('account')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(false);
        $this->shouldThrow(\RuntimeException::CLASS)->during('beforeOpeningRecordNode', [$node]);
    }

    function it_throws_on_invalid_bgc_nr_in_opening_node($orgBg, OpeningRecordNode $node, Bankgiro $payeeBg)
    {
        $node->getChild('payee_bgc_number')->willReturn($node);
        $node->getValue()->willReturn('some-invalid-value');
        $node->getChild('payee_bankgiro')->willReturn($node);
        $node->getAttribute('account')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(true);
        $this->shouldThrow(\RuntimeException::CLASS)->during('beforeOpeningRecordNode', [$node]);
    }

    function it_throws_on_invalid_bg_in_request_opening($orgBg, RequestOpeningRecordNode $node, Bankgiro $payeeBg)
    {
        $node->getChild('payee_bgc_number')->willReturn($node);
        $node->getValue()->willReturn(self::ORG_BGC_NR);
        $node->getChild('payee_bankgiro')->willReturn($node);
        $node->getAttribute('account')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(false);
        $this->shouldThrow(\RuntimeException::CLASS)->during('beforeRequestOpeningRecordNode', [$node]);
    }

    function it_throws_on_invalid_bgc_nr_in_request_opening($orgBg, RequestOpeningRecordNode $node, Bankgiro $payeeBg)
    {
        $node->getChild('payee_bgc_number')->willReturn($node);
        $node->getValue()->willReturn('some-invalid-value');
        $node->getChild('payee_bankgiro')->willReturn($node);
        $node->getAttribute('account')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(true);
        $this->shouldThrow(\RuntimeException::CLASS)->during('beforeRequestOpeningRecordNode', [$node]);
    }
}
