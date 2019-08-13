<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Autogiro;

use byrokrat\giroapp\Autogiro\AutogiroVisitor;
use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\CommandBus\ForceState;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Exception\InvalidAutogiroFileException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\Error;
use byrokrat\giroapp\Domain\State\Paused;
use byrokrat\giroapp\Domain\State\Revoked;
use byrokrat\giroapp\Event\TransactionFailed;
use byrokrat\giroapp\Event\TransactionPerformed;
use byrokrat\giroapp\Workflow\Transitions;
use byrokrat\amount\Currency\SEK;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AutogiroVisitorSpec extends ObjectBehavior
{
    function let(
        ConfigInterface $orgBgcNr,
        AccountNumber $orgBg,
        CommandBusInterface $commandBus,
        DonorQueryInterface $donorQuery,
        EventDispatcherInterface $dispatcher
    ) {
        $this->beConstructedWith($orgBgcNr, $orgBg);
        $this->setCommandBus($commandBus);
        $this->setDonorQuery($donorQuery);
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

    function it_fails_on_mandate_response_if_node_contains_invalid_id(
        $donorQuery,
        Node $parentNode,
        Donor $donor,
        Node $idNode,
        IdInterface $nodeId,
        IdInterface $donorId
    ) {
        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('StateId')->willReturn($idNode);
        $idNode->getValueFrom('Object')->willReturn($nodeId);

        $donor->getDonorId()->willReturn($donorId);
        $donor->getPayerNumber()->willReturn('');

        $nodeId->format('S-sk')->willReturn('foo');
        $donorId->format('S-sk')->willReturn('NOT-foo');

        $this->shouldThrow(InvalidAutogiroFileException::CLASS)->duringBeforeMandateResponse($parentNode);
    }

    function it_fails_on_mandate_response_if_node_contains_invalid_account(
        $donorQuery,
        Node $parentNode,
        Donor $donor,
        Node $idNode,
        Node $accountNode,
        AccountNumber $nodeAccount,
        AccountNumber $donorAccount
    ) {
        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('StateId')->willReturn($idNode);
        $idNode->getValueFrom('Object')->willReturn(null);

        $parentNode->getChild('Account')->willReturn($accountNode);
        $accountNode->getValueFrom('Object')->willReturn($nodeAccount);

        $donor->getAccount()->willReturn($donorAccount);
        $donor->getPayerNumber()->willReturn('');

        $nodeAccount->getNumber()->willReturn('');
        $donorAccount->getNumber()->willReturn('');
        $nodeAccount->equals($donorAccount)->willReturn(false);

        $this->shouldThrow(InvalidAutogiroFileException::CLASS)->duringBeforeMandateResponse($parentNode);
    }

    function it_fails_on_mandate_response_if_unknown_response_code(
        $donorQuery,
        Node $parentNode,
        Donor $donor,
        Node $idNode,
        Node $accountNode,
        Node $statusNode
    ) {
        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('StateId')->willReturn($idNode);
        $idNode->getValueFrom('Object')->willReturn(null);

        $parentNode->getChild('Account')->willReturn($accountNode);
        $accountNode->getValueFrom('Object')->willReturn(null);

        $parentNode->hasChild('CreatedFlag')->willReturn(false);
        $parentNode->hasChild('DeletedFlag')->willReturn(false);
        $parentNode->hasChild('ErrorFlag')->willReturn(false);

        $donor->getMandateKey()->willReturn('');
        $parentNode->getChild('Status')->willReturn($statusNode);
        $statusNode->getValueFrom('Number')->willReturn('');
        $statusNode->getValueFrom('Text')->willReturn('');

        $this->shouldThrow(InvalidAutogiroFileException::CLASS)->duringBeforeMandateResponse($parentNode);
    }

    function it_handles_on_mandate_response_if_created(
        $donorQuery,
        $commandBus,
        Node $parentNode,
        Donor $donor,
        Node $idNode,
        Node $accountNode,
        Node $statusNode
    ) {
        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('StateId')->willReturn($idNode);
        $idNode->getValueFrom('Object')->willReturn(null);

        $parentNode->getChild('Account')->willReturn($accountNode);
        $accountNode->getValueFrom('Object')->willReturn(null);

        $parentNode->hasChild('CreatedFlag')->willReturn(true);

        $parentNode->getChild('Status')->willReturn($statusNode);
        $statusNode->getValueFrom('Text')->willReturn('desc');

        $commandBus->handle(
            new UpdateState($donor->getWrappedObject(), Transitions::MARK_MANDATE_REGISTERED, 'desc')
        )->shouldBeCalled();

        $this->beforeMandateResponse($parentNode);
    }

    function it_handles_on_mandate_response_if_deleted(
        $donorQuery,
        $commandBus,
        Node $parentNode,
        Donor $donor,
        Node $idNode,
        Node $accountNode,
        Node $statusNode
    ) {
        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('StateId')->willReturn($idNode);
        $idNode->getValueFrom('Object')->willReturn(null);

        $parentNode->getChild('Account')->willReturn($accountNode);
        $accountNode->getValueFrom('Object')->willReturn(null);

        $parentNode->hasChild('CreatedFlag')->willReturn(false);
        $parentNode->hasChild('DeletedFlag')->willReturn(true);

        $parentNode->getChild('Status')->willReturn($statusNode);
        $statusNode->getValueFrom('Text')->willReturn('desc');

        $commandBus->handle(
            new ForceState($donor->getWrappedObject(), Revoked::getStateId(), 'desc')
        )->shouldBeCalled();

        $this->beforeMandateResponse($parentNode);
    }

    function it_handles_on_mandate_response_if_error(
        $donorQuery,
        $commandBus,
        Node $parentNode,
        Donor $donor,
        Node $idNode,
        Node $accountNode,
        Node $statusNode
    ) {
        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('StateId')->willReturn($idNode);
        $idNode->getValueFrom('Object')->willReturn(null);

        $parentNode->getChild('Account')->willReturn($accountNode);
        $accountNode->getValueFrom('Object')->willReturn(null);

        $parentNode->hasChild('CreatedFlag')->willReturn(false);
        $parentNode->hasChild('DeletedFlag')->willReturn(false);
        $parentNode->hasChild('ErrorFlag')->willReturn(true);

        $parentNode->getChild('Status')->willReturn($statusNode);
        $statusNode->getValueFrom('Text')->willReturn('desc');

        $commandBus->handle(
            new ForceState($donor->getWrappedObject(), Error::getStateId(), 'desc')
        )->shouldBeCalled();

        $this->beforeMandateResponse($parentNode);
    }

    function it_handles_successful_payment_amendment_responses(
        $donorQuery,
        $commandBus,
        Node $parentNode,
        Donor $donor,
        Node $dateNode
    ) {
        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('Date')->willReturn($dateNode);
        $dateNode->getValueFrom('Object')->willReturn(new \DateTimeImmutable('20190812'));

        $parentNode->hasChild('RevocationFlag')->willReturn(true);

        $commandBus->handle(
            new UpdateState(
                $donor->getWrappedObject(),
                Transitions::MARK_TRANSACTION_REMOVED,
                'Transaction paused on 2019-08-12'
            )
        )->shouldBeCalled();

        $this->beforeSuccessfulIncomingAmendmentResponse($parentNode);
    }

    function it_handles_successful_payment_responses(
        $donorQuery,
        $commandBus,
        $dispatcher,
        Node $parentNode,
        Donor $donor,
        Node $dateNode,
        Node $amountNode
    ) {
        $donor->getMandateKey()->willReturn('');

        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('Date')->willReturn($dateNode);
        $dateNode->getValueFrom('Object')->willReturn(new \DateTimeImmutable('20190812'));

        $parentNode->getChild('Amount')->willReturn($amountNode);
        $amountNode->getValueFrom('Object')->willReturn(new SEK('100'));

        $commandBus->handle(
            new UpdateState(
                $donor->getWrappedObject(),
                Transitions::MARK_TRANSACTION_ACTIVE,
                'Transaction active on 2019-08-12'
            )
        )->shouldBeCalled();

        $dispatcher->dispatch(Argument::type(TransactionPerformed::CLASS))->shouldBeCalled();

        $this->beforeSuccessfulIncomingPaymentResponse($parentNode);
    }

    function it_handles_failed_payment_responses(
        $donorQuery,
        $commandBus,
        $dispatcher,
        Node $parentNode,
        Donor $donor,
        Node $dateNode,
        Node $amountNode
    ) {
        $donor->getMandateKey()->willReturn('');

        $parentNode->getValueFrom('PayerNumber')->willReturn('payer-number');
        $donorQuery->requireByPayerNumber('payer-number')->willReturn($donor);

        $parentNode->getChild('Date')->willReturn($dateNode);
        $dateNode->getValueFrom('Object')->willReturn(new \DateTimeImmutable('20190812'));

        $parentNode->getChild('Amount')->willReturn($amountNode);
        $amountNode->getValueFrom('Object')->willReturn(new SEK('100'));

        $commandBus->handle(
            new UpdateState(
                $donor->getWrappedObject(),
                Transitions::MARK_TRANSACTION_ACTIVE,
                'Transaction active on 2019-08-12'
            )
        )->shouldBeCalled();

        $dispatcher->dispatch(Argument::type(TransactionFailed::CLASS))->shouldBeCalled();

        $this->beforeFailedIncomingPaymentResponse($parentNode);
    }
}
