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
use byrokrat\giroapp\Model\DonorState\MandateApprovedState;
use byrokrat\giroapp\Model\DonorState\InactiveState;
use byrokrat\giroapp\Model\DonorState\ErrorState;
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
        Node $infoNode,
        Node $commentNode,
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

        $parentNode->getChild('info')->willReturn($infoNode);
        $infoNode->getValue()->willReturn('');

        $parentNode->getChild('comment')->willReturn($commentNode);
        $commentNode->getValue()->willReturn('');

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

        $this->__invoke($event, '', $dispatcher);
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

        $this->__invoke($event, '', $dispatcher);
    }

    function it_fails_on_unknown_response_code(
        $event,
        $infoNode,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn('this-is-not-a-valid-autogiro-reposnose-code');

        $dispatcher->dispatch(Events::WARNING_EVENT, Argument::type(LogEvent::CLASS))->shouldBeCalled();
        $event->stopPropagation()->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_error_state_on_updated_payer_number(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_UPDATED_PAYER_NUMBER_BY_RECIPIENT);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_error_state_on_specific_mandate_response_from_bank(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_ACCOUNT_RESPONSE_FROM_BANK);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_error_state_on_mandate_deleted_due_to_unanswered_request(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_DELETED_DUE_TO_UNANSWERED_ACCOUNT_REQUEST);

        $donor->setState(Argument::type(ErrorState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_by_payer(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_DELETED_BY_PAYER);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_by_recipient(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_DELETED_BY_RECIPIENT);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_due_to_closed_recipient_bg(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_DELETED_DUE_TO_CLOSED_RECIPIENT_BG);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_inactive_state_on_mandate_deleted_due_to_closed_payer_bg(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_DELETED_DUE_TO_CLOSED_PAYER_BG);

        $donor->setState(Argument::type(InactiveState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }

    function it_sets_approved_state_on_mandate_created(
        $event,
        $infoNode,
        $donor,
        $donorMapper,
        EventDispatcherInterface $dispatcher
    ) {
        $infoNode->getValue()->willReturn(Messages::MANDATE_CREATED_BY_RECIPIENT);

        $donor->setState(Argument::type(MandateApprovedState::CLASS))->shouldBeCalled();
        $dispatcher->dispatch(Events::MANDATE_APPROVED_EVENT, Argument::type(DonorEvent::CLASS))->shouldBeCalled();
        $donorMapper->save($donor)->shouldBeCalled();

        $this->__invoke($event, '', $dispatcher);
    }
}
