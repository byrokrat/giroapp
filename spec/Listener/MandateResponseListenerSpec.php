<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Listener;

use byrokrat\giroapp\Listener\MandateResponseListener;
use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\StatePool;
use byrokrat\giroapp\States;
use byrokrat\id\IdInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Messages;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MandateResponseListenerSpec extends ObjectBehavior
{
    function let(
        NodeEvent $event,
        Node $parentNode,
        Node $payerNumberNode,
        Node $idNode,
        Node $accountNode,
        Node $statusNode,
        Donor $donor,
        DonorMapper $donorMapper,
        StatePool $statePool,
        StateInterface $errorState,
        StateInterface $inactiveState,
        StateInterface $approvedState
    ) {
        $event->getNode()->willReturn($parentNode);

        $parentNode->getChild('payer_number')->willReturn($payerNumberNode);
        $payerNumberNode->getValue()->willReturn('payer-number');

        $parentNode->getChild('id')->willReturn($idNode);
        $idNode->hasAttribute('id')->willReturn(false);

        $parentNode->getChild('account')->willReturn($accountNode);
        $accountNode->hasAttribute('account')->willReturn(false);

        $parentNode->getChild('status')->willReturn($statusNode);
        $statusNode->getValue()->willReturn('');
        $statusNode->getAttribute('message_id')->willReturn('');
        $statusNode->getAttribute('message')->willReturn('');

        $donorMapper->findByActivePayerNumber('payer-number')->willReturn($donor);

        $donor->getPayerNumber()->willReturn('');
        $donor->getMandateKey()->willReturn('');

        $statePool->getState(States::MANDATE_APPROVED)->willReturn($approvedState);
        $statePool->getState(States::INACTIVE)->willReturn($inactiveState);
        $statePool->getState(States::ERROR)->willReturn($errorState);

        $this->beConstructedWith($donorMapper, $statePool);
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
        $idNode->hasAttribute('id')->willReturn(true);
        $idNode->getAttribute('id')->willReturn($nodeId);

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
        $accountNode->hasAttribute('account')->willReturn(true);
        $accountNode->getAttribute('account')->willReturn($nodeAccount);

        $donor->getAccount()->willReturn($donorAccount);

        $donorAccount->equals($nodeAccount)->willReturn(false);

        $nodeAccount->getNumber()->willReturn('');
        $donorAccount->getNumber()->willReturn('');

        $disp->dispatch(Events::WARNING, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseReceived($event, '', $disp);
    }

    function it_fails_on_unknown_response_code($event, $statusNode, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn('this-is-not-a-valid-autogiro-reposnose-code');
        $disp->dispatch(Events::WARNING, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_inactive_on_mandate_deleted_by_payer($event, $statusNode, $donor, $inactiveState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_BY_PAYER);
        $donor->setState($inactiveState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_REVOKED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_account_not_allowed($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_ACCOUNT_NOT_ALLOWED);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_mandate_does_not_exist($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DOES_NOT_EXIST);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_invalid_account_or_id($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_ACCOUNT_OR_ID);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_inactive_on_mandate_del_unanswered_request(
        $event,
        $statusNode,
        $donor,
        $inactiveState,
        Dispatcher $disp
    ) {
        $statusNode->getAttribute('message_id')->willReturn(
            Messages::STATUS_MANDATE_DELETED_DUE_TO_UNANSWERED_ACCOUNT_REQUEST
        );
        $donor->setState($inactiveState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_REVOKED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_payer_number_does_not_exist($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_PAYER_NUMBER_DOES_NOT_EXIST);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_mandate_already_exists($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_ALREADY_EXISTS);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_invalid_id_or_bg_not_allowed($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_ID_OR_BG_NOT_ALLOWED);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_invalid_payer_number($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_PAYER_NUMBER);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_invalid_account($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_ACCOUNT);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_invalid_payee_account($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_PAYEE_ACCOUNT);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_inactive_payee_account($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INACTIVE_PAYEE_ACCOUNT);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_approved_on_mandate_created($event, $statusNode, $donor, $approvedState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_CREATED);
        $donor->setState($approvedState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_APPROVED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_inactive_on_mandate_deleted($event, $statusNode, $donor, $inactiveState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED);
        $donor->setState($inactiveState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_REVOKED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_inactive_on_mandate_del_closed_payer_bg($event, $statusNode, $donor, $inactiveState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_DUE_TO_CLOSED_PAYER_BG);
        $donor->setState($inactiveState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_REVOKED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_inactive_on_mandate_deleted_by_bank($event, $statusNode, $donor, $inactiveState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_BY_BANK);
        $donor->setState($inactiveState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_REVOKED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_inactive_on_mandate_deleted_by_bgc($event, $statusNode, $donor, $inactiveState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_BY_BGC);
        $donor->setState($inactiveState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_REVOKED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_mandate_blocked_by_payer($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_BLOCKED_BY_PAYER);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_mandate_block_removed($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_BLOCK_REMOVED);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }

    function its_error_on_mandate_max_amount_not_allowed($event, $statusNode, $donor, $errorState, Dispatcher $disp)
    {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_MAX_AMOUNT_NOT_ALLOWED);
        $donor->setState($errorState)->shouldBeCalled();
        $disp->dispatch(Events::MANDATE_INVALIDATED, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $this->onMandateResponseReceived($event, '', $disp);
    }
}
