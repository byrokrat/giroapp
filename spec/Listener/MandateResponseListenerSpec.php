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
use byrokrat\giroapp\State\MandateApprovedState;
use byrokrat\giroapp\State\InactiveState;
use byrokrat\giroapp\State\ErrorState;
use byrokrat\id\Id;
use byrokrat\banking\AccountNumber;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Messages;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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
        DonorMapper $donorMapper
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

        $this->beConstructedWith($donorMapper);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MandateResponseListener::CLASS);
    }

    function it_fails_if_node_contains_invalid_id(
        $event,
        $idNode,
        $donor,
        Id $nodeId,
        Id $donorId,
        EventDispatcherInterface $dispatcher
    ) {
        $idNode->hasAttribute('id')->willReturn(true);
        $idNode->getAttribute('id')->willReturn($nodeId);

        $donor->getDonorId()->willReturn($donorId);

        $nodeId->format('S-sk')->willReturn('foo');
        $donorId->format('S-sk')->willReturn('NOT-foo');

        $dispatcher->dispatch(Events::WARNING_EVENT, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_fails_if_node_contains_invalid_account(
        $event,
        $accountNode,
        $donor,
        AccountNumber $nodeAccount,
        AccountNumber $donorAccount,
        EventDispatcherInterface $dispatcher
    ) {
        $accountNode->hasAttribute('account')->willReturn(true);
        $accountNode->getAttribute('account')->willReturn($nodeAccount);

        $donor->getAccount()->willReturn($donorAccount);

        $donorAccount->equals($nodeAccount)->willReturn(false);

        $nodeAccount->getNumber()->willReturn('');
        $donorAccount->getNumber()->willReturn('');

        $dispatcher->dispatch(Events::WARNING_EVENT, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_fails_on_unknown_response_code(
        $event,
        $statusNode,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn('this-is-not-a-valid-autogiro-reposnose-code');

        $dispatcher->dispatch(Events::WARNING_EVENT, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_by_payer(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_BY_PAYER);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_account_not_allowed(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_ACCOUNT_NOT_ALLOWED);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_mandate_does_not_exist(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DOES_NOT_EXIST);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_invalid_account_or_id(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_ACCOUNT_OR_ID);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_due_to_unanswered_request(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(
            Messages::STATUS_MANDATE_DELETED_DUE_TO_UNANSWERED_ACCOUNT_REQUEST
        );

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_payer_number_does_not_exist(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_PAYER_NUMBER_DOES_NOT_EXIST);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_mandate_already_exists(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_ALREADY_EXISTS);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_invalid_id_or_bg_not_allowed(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_ID_OR_BG_NOT_ALLOWED);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_invalid_payer_number(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_PAYER_NUMBER);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_invalid_account(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_ACCOUNT);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_invalid_payee_account(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INVALID_PAYEE_ACCOUNT);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_inactive_payee_account(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_INACTIVE_PAYEE_ACCOUNT);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_approved_state_on_mandate_created(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_CREATED);

        $donor->setState(Argument::type(MandateApprovedState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_APPROVED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_due_to_closed_payer_bg(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_DUE_TO_CLOSED_PAYER_BG);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_by_bank(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_BY_BANK);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_by_bgc(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_DELETED_BY_BGC);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_mandate_blocked_by_payer(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_BLOCKED_BY_PAYER);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_mandate_block_removed(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_BLOCK_REMOVED);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }

    function it_sets_error_state_on_mandate_max_amount_not_allowed(
        $event,
        $statusNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $statusNode->getAttribute('message_id')->willReturn(Messages::STATUS_MANDATE_MAX_AMOUNT_NOT_ALLOWED);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->update($donor)->shouldBeCalled();

        $this->onMandateResponseEvent($event, '', $dispatcher);
    }
}
