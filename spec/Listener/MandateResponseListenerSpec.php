<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\MandateResponseListener;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\State\Error;
use byrokrat\giroapp\State\Inactive;
use byrokrat\giroapp\State\MandateApproved;
use byrokrat\id\IdInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\autogiro\Tree\Node;
use League\Tactician\CommandBus;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MandateResponseListenerSpec extends ObjectBehavior
{
    function let(
        NodeEvent $event,
        Node $parentNode,
        Node $idNode,
        Node $accountNode,
        Node $statusNode,
        Donor $donor,
        DonorQueryInterface $donorQuery,
        CommandBus $commandBus,
        EventDispatcherInterface $dispatcher
    ) {
        $event->getNode()->willReturn($parentNode);

        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');

        $parentNode->getChild('StateId')->willReturn($idNode);
        $idNode->getValueFrom('Object')->willReturn(null);

        $parentNode->getChild('Account')->willReturn($accountNode);
        $accountNode->getValueFrom('Object')->willReturn(null);

        $parentNode->getChild('Status')->willReturn($statusNode);
        $statusNode->getValueFrom('Text')->willReturn('');
        $statusNode->getValueFrom('Number')->willReturn('');

        $parentNode->hasChild('CreatedFlag')->willReturn(false);
        $parentNode->hasChild('DeletedFlag')->willReturn(false);
        $parentNode->hasChild('ErrorFlag')->willReturn(false);

        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $donor->getPayerNumber()->willReturn('');
        $donor->getMandateKey()->willReturn('');

        $this->setCommandBus($commandBus);
        $this->setEventDispatcher($dispatcher);
        $this->setDonorQuery($donorQuery);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MandateResponseListener::CLASS);
    }

    function it_fails_if_node_contains_invalid_id(
        $event,
        $idNode,
        $donor,
        $dispatcher,
        IdInterface $nodeId,
        IdInterface $donorId
    ) {
        $idNode->getValueFrom('Object')->willReturn($nodeId);
        $donor->getDonorId()->willReturn($donorId);

        $nodeId->format('S-sk')->willReturn('foo');
        $donorId->format('S-sk')->willReturn('NOT-foo');

        $dispatcher->dispatch(LogEvent::CLASS, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseReceived($event);
    }

    function it_fails_if_node_contains_invalid_account(
        $event,
        $accountNode,
        $donor,
        $dispatcher,
        AccountNumber $nodeAccount,
        AccountNumber $donorAccount
    ) {
        $accountNode->getValueFrom('Object')->willReturn($nodeAccount);
        $donor->getAccount()->willReturn($donorAccount);

        $donorAccount->equals($nodeAccount)->willReturn(false);

        $nodeAccount->getNumber()->willReturn('');
        $donorAccount->getNumber()->willReturn('');

        $dispatcher->dispatch(LogEvent::CLASS, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseReceived($event);
    }

    function it_fails_on_unknown_response_code($event, $dispatcher)
    {
        $dispatcher->dispatch(LogEvent::CLASS, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();
        $this->onMandateResponseReceived($event);
    }

    function its_inactive_on_mandate_deleted_response($event, $parentNode, $donor, $commandBus)
    {
        $parentNode->hasChild('DeletedFlag')->willReturn(true);
        $commandBus->handle(new UpdateState($donor->getWrappedObject(), Inactive::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event);
    }

    function its_error_on_error_response($event, $parentNode, $donor, $commandBus)
    {
        $parentNode->hasChild('ErrorFlag')->willReturn(true);
        $commandBus->handle(new UpdateState($donor->getWrappedObject(), Error::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event);
    }

    function its_approved_on_created_response($event, $parentNode, $donor, $commandBus)
    {
        $parentNode->hasChild('CreatedFlag')->willReturn(true);
        $commandBus->handle(new UpdateState($donor->getWrappedObject(), MandateApproved::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event);
    }
}
