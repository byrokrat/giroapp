<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp;

use byrokrat\giroapp\AutogiroVisitor;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Exception\InvalidAutogiroFileException;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\autogiro\Tree\Node;
use byrokrat\banking\AccountNumber;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutogiroVisitorSpec extends ObjectBehavior
{
    function let(Dispatcher $dispatcher, ConfigInterface $orgBgcNr, AccountNumber $orgBg)
    {
        $this->beConstructedWith($orgBgcNr, $orgBg);
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

    function it_throws_on_invalid_bg_in_opening_node($orgBgcNr, $orgBg, Node $node, AccountNumber $payeeBg)
    {
        $orgBgcNr->getValue()->willReturn('org-bgc-nr');
        $node->getChild('PayeeBgcNumber')->willReturn($node);
        $node->getValue()->willReturn('org-bgc-nr');
        $node->getChild('PayeeBankgiro')->willReturn($node);
        $node->getValueFrom('Object')->willReturn($payeeBg);
        $orgBg->getNumber()->willReturn('');
        $payeeBg->equals($orgBg)->willReturn(false);
        $payeeBg->getNumber()->willReturn('');
        $this->shouldThrow(InvalidAutogiroFileException::CLASS)->during('beforeOpening', [$node]);
    }

    function it_throws_on_invalid_bgc_nr_in_opening_node($orgBgcNr, $orgBg, Node $node, AccountNumber $payeeBg)
    {
        $orgBgcNr->getValue()->willReturn('org-bgc-nr');
        $node->getChild('PayeeBgcNumber')->willReturn($node);
        $node->getValue()->willReturn('invalid-org-bgc-nr');
        $node->getChild('PayeeBankgiro')->willReturn($node);
        $node->getValueFrom('Object')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(true);
        $this->shouldThrow(InvalidAutogiroFileException::CLASS)->during('beforeOpening', [$node]);
    }

    function it_ignores_missing__bgc_nr_in_opening_node($orgBgcNr, $orgBg, Node $node, AccountNumber $payeeBg)
    {
        $orgBgcNr->getValue()->willReturn('org-bgc-nr');
        $node->getChild('PayeeBgcNumber')->willReturn($node);
        $node->getValue()->willReturn(null);
        $node->getChild('PayeeBankgiro')->willReturn($node);
        $node->getValueFrom('Object')->willReturn($payeeBg);
        $payeeBg->equals($orgBg)->willReturn(true);
        $this->beforeOpening($node);
    }

    function it_ignores_missing_bg_in_opening_node($orgBgcNr, $orgBg, Node $node)
    {
        $orgBgcNr->getValue()->willReturn('org-bgc-nr');
        $node->getChild('PayeeBgcNumber')->willReturn($node);
        $node->getValue()->willReturn('org-bgc-nr');
        $node->getChild('PayeeBankgiro')->willReturn($node);
        $node->getValueFrom('Object')->willReturn(null);
        $this->beforeOpening($node);
    }
}
