<?php
/**
 * This file is part of byrokrat\giroapp.
 *
 * byrokrat\giroapp is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * byrokrat\giroapp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with byrokrat\giroapp. If not, see <http://www.gnu.org/licenses/>.
 *
 * Copyright 2016-19 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Autogiro;

use byrokrat\giroapp\CommandBus\AttemptState;
use byrokrat\giroapp\CommandBus\ForceState;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Exception\InvalidAutogiroFileException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\Error;
use byrokrat\giroapp\Domain\State\Revoked;
use byrokrat\giroapp\Event\TransactionFailed;
use byrokrat\giroapp\Event\TransactionPerformed;
use byrokrat\giroapp\Workflow\Transitions;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\autogiro\Tree\Node;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;

class AutogiroVisitor extends Visitor
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\DispatcherProperty,
        DependencyInjection\DonorQueryProperty;

    /** @var ConfigInterface */
    private $orgBgcNr;

    /** @var AccountNumber */
    private $orgBankgiro;

    public function __construct(ConfigInterface $orgBgcNr, AccountNumber $orgBankgiro)
    {
        $this->orgBgcNr = $orgBgcNr;
        $this->orgBankgiro = $orgBankgiro;
    }

    public function beforeOpening(Node $node): void
    {
        /** @var string $payeeBgcNr */
        $payeeBgcNr = (string)$node->getChild('PayeeBgcNumber')->getValue();

        /** @var ?AccountNumber $payeeBankgiro */
        $payeeBankgiro = $node->getChild('PayeeBankgiro')->getValueFrom('Object');

        if ($payeeBgcNr && $payeeBgcNr != $this->orgBgcNr->getValue()) {
            throw new InvalidAutogiroFileException(
                sprintf(
                    'File contains invalid payee BGC customer number, found: %s, expexting: %s',
                    $payeeBgcNr,
                    $this->orgBgcNr->getValue()
                )
            );
        }

        if ($payeeBankgiro && !$payeeBankgiro->equals($this->orgBankgiro)) {
            throw new InvalidAutogiroFileException(
                sprintf(
                    'File contains invalid payee bankgiro account number, found: %s, expexting: %s',
                    $payeeBankgiro->getNumber(),
                    $this->orgBankgiro->getNumber()
                )
            );
        }
    }

    public function beforeMandateResponse(Node $node): void
    {
        $donor = $this->donorQuery->requireByPayerNumber($node->getValueFrom('PayerNumber'));

        /** @var ?IdInterface $nodeId */
        if ($nodeId = $node->getChild('StateId')->getValueFrom('Object')) {
            $this->validateDonorId($nodeId, $donor);
        }

        /** @var ?AccountNumber $nodeAccount */
        if ($nodeAccount = $node->getChild('Account')->getValueFrom('Object')) {
            $this->validateDonorAccountNumber($nodeAccount, $donor);
        }

        $desc = (string)$node->getChild('Status')->getValueFrom('Text');

        if ($node->hasChild('CreatedFlag')) {
            $this->commandBus->handle(new UpdateState($donor, Transitions::IMPORT_MANDATE_REGISTERED, $desc));

            return;
        }

        if ($node->hasChild('DeletedFlag')) {
            $this->commandBus->handle(new ForceState($donor, Revoked::getStateId(), $desc));

            return;
        }

        if ($node->hasChild('ErrorFlag')) {
            $this->commandBus->handle(new ForceState($donor, Error::getStateId(), $desc));

            return;
        }

        throw new InvalidAutogiroFileException(
            sprintf(
                '%s: invalid mandate status code: %s',
                $donor->getMandateKey(),
                (string)$node->getChild('Status')->getValueFrom('Number')
            )
        );
    }

    public function beforeSuccessfulIncomingAmendmentResponse(Node $node): void
    {
        $donor = $this->donorQuery->requireByPayerNumber($node->getValueFrom('PayerNumber'));

        /** @var \DateTimeImmutable $date */
        $date = $node->getChild('Date')->getValueFrom('Object');

        if ($node->hasChild('RevocationFlag')) {
            $this->commandBus->handle(
                new UpdateState(
                    $donor,
                    Transitions::IMPORT_TRANSACTION_REMOVED,
                    'Transaction paused on ' . $date->format('Y-m-d')
                )
            );
        }
    }

    public function beforeSuccessfulIncomingPaymentResponse(Node $node): void
    {
        $this->processIncomingPayment($node, true);
    }

    public function beforeFailedIncomingPaymentResponse(Node $node): void
    {
        $this->processIncomingPayment($node, false);
    }

    private function processIncomingPayment(Node $node, bool $success): void
    {
        $donor = $this->donorQuery->requireByPayerNumber($node->getValueFrom('PayerNumber'));

        /** @var \DateTimeImmutable $date */
        $date = $node->getChild('Date')->getValueFrom('Object');

        $this->commandBus->handle(
            new AttemptState(
                $donor,
                Transitions::IMPORT_TRANSACTION_ACTIVE,
                'Transaction active on ' . $date->format('Y-m-d')
            )
        );

        /** @var \byrokrat\amount\Currency\SEK $amount */
        $amount = $node->getChild('Amount')->getValueFrom('Object');

        $eventClassName = $success ? TransactionPerformed::class : TransactionFailed::class;

        $this->dispatcher->dispatch(new $eventClassName($donor, $amount, $date));
    }

    private function validateDonorAccountNumber(AccountNumber $nodeAccount, Donor $donor): void
    {
        if (!$nodeAccount->equals($donor->getAccount())) {
            throw new InvalidAutogiroFileException(
                sprintf(
                    "Invalid mandate response for payer number '%s', found account '%s', expecting '%s'",
                    $donor->getPayerNumber(),
                    $nodeAccount->getNumber(),
                    $donor->getAccount()->getNumber()
                )
            );
        }
    }

    private function validateDonorId(IdInterface $nodeId, Donor $donor): void
    {
        if ($nodeId->format('S-sk') != $donor->getDonorId()->format('S-sk')) {
            throw new InvalidAutogiroFileException(
                sprintf(
                    "Invalid mandate response for payer number '%s', found donor id '%s', expecting '%s'",
                    $donor->getPayerNumber(),
                    $nodeId->format('S-sk'),
                    $donor->getDonorId()->format('S-sk')
                )
            );
        }
    }
}
