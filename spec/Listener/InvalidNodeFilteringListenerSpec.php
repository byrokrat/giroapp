<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\InvalidNodeFilteringListener;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Mapper\SettingsMapper;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Tree\FileNode;
use byrokrat\autogiro\Tree\Record\Response\MandateResponseNode;
use byrokrat\banking\AccountNumber;
use byrokrat\banking\BankgiroFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidNodeFilteringListenerSpec extends ObjectBehavior
{
    function let(BankgiroFactory $bankgiroFactory, SettingsMapper $settingsMapper)
    {
        $this->beConstructedWith($bankgiroFactory, $settingsMapper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidNodeFilteringListener::CLASS);
    }

    function it_ignores_valid_nodes(
        NodeEvent $event,
        AccountNumber $bankgiro,
        Node $parentNode,
        Node $payeeBankgiroNode,
        EventDispatcherInterface $dispatcher,
        $bankgiroFactory,
        $settingsMapper
    ) {
        $settingsMapper->read('bankgiro')->willReturn('baz');
        $bankgiroFactory->createAccount('baz')->willReturn($bankgiro);

        $parentNode->getChild('payee_bankgiro')->willReturn($payeeBankgiroNode);
        $payeeBankgiroNode->getAttribute('account')->willReturn($bankgiro);

        $bankgiro->equals($bankgiro)->willReturn(true)->shouldBeCalled();

        $event->getNode()->willReturn($parentNode);

        $this->__invoke($event, '', $dispatcher);
    }

    function it_dies_on_invalid_nodes(
        NodeEvent $event,
        AccountNumber $bankgiro,
        Node $parentNode,
        Node $payeeBankgiroNode,
        EventDispatcherInterface $dispatcher,
        $bankgiroFactory,
        $settingsMapper
    ) {
        $settingsMapper->read('bankgiro')->willReturn('baz');
        $bankgiroFactory->createAccount('baz')->willReturn($bankgiro);

        $parentNode->getChild('payee_bankgiro')->willReturn($payeeBankgiroNode);
        $payeeBankgiroNode->getAttribute('account')->willReturn($bankgiro);

        $bankgiro->equals($bankgiro)->willReturn(false)->shouldBeCalled();

        $event->getNode()->willReturn($parentNode);
        $event->stopPropagation()->shouldBeCalled();

        $bankgiro->__toString()->willReturn('');

        $dispatcher->dispatch(Events::ERROR_EVENT, Argument::type(LogEvent::CLASS))->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }
}
