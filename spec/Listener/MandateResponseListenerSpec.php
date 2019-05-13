<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\MandateResponseListener;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\States;
use byrokrat\id\IdInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\autogiro\Tree\Node;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
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
        StateCollection $stateCollection,
        StateInterface $errorState,
        StateInterface $inactiveState,
        StateInterface $approvedState
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

        $stateCollection->getState(States::MANDATE_APPROVED)->willReturn($approvedState);
        $stateCollection->getState(States::INACTIVE)->willReturn($inactiveState);
        $stateCollection->getState(States::ERROR)->willReturn($errorState);

        $this->beConstructedWith($donorQuery, $stateCollection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MandateResponseListener::CLASS);
    }

    function it_fails_if_node_contains_invalid_id(
        $event,
        $idNode,
        $donor,
        IdInterface $nodeId,
        IdInterface $donorId,
        Dispatcher $disp
    ) {
        $idNode->getValueFrom('Object')->willReturn($nodeId);
        $donor->getDonorId()->willReturn($donorId);

        $nodeId->format('S-sk')->willReturn('foo');
        $donorId->format('S-sk')->willReturn('NOT-foo');

        $disp->dispatch(Events::WARNING, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseReceived($event, '', $disp);
    }

    function it_fails_if_node_contains_invalid_account(
        $event,
        $accountNode,
        $donor,
        AccountNumber $nodeAccount,
        AccountNumber $donorAccount,
        Dispatcher $disp
    ) {
        $accountNode->getValueFrom('Object')->willReturn($nodeAccount);
        $donor->getAccount()->willReturn($donorAccount);

        $donorAccount->equals($nodeAccount)->willReturn(false);

        $nodeAccount->getNumber()->willReturn('');
        $donorAccount->getNumber()->willReturn('');

        $disp->dispatch(Events::WARNING, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseReceived($event, '', $disp);
    }

    function it_fails_on_unknown_response_code($event, Dispatcher $disp)
    {
        $disp->dispatch(Events::WARNING, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_inactive_on_mandate_deleted_response($event, $parentNode, $donor, $inactiveState, Dispatcher $disp)
    {
        $parentNode->hasChild('DeletedFlag')->willReturn(true);
        $donor->setState($inactiveState, Argument::type('string'))->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_REVOKED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_error_response($event, $parentNode, $donor, $errorState, Dispatcher $disp)
    {
        $parentNode->hasChild('ErrorFlag')->willReturn(true);
        $donor->setState($errorState, Argument::type('string'))->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_approved_on_created_response($event, $parentNode, $donor, $approvedState, Dispatcher $disp)
    {
        $parentNode->hasChild('CreatedFlag')->willReturn(true);
        $donor->setState($approvedState, Argument::type('string'))->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_APPROVED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }
}
