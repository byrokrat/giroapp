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
 * Copyright 2016-21 Hannes Forsgård
 */

declare(strict_types=1);

namespace byrokrat\giroapp\Autogiro;

use byrokrat\giroapp\CommandBus\AttemptState;
use byrokrat\giroapp\CommandBus\ForceState;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Exception\InvalidAutogiroFileException;
use byrokrat\giroapp\Exception\DonorDoesNotExistException;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\State\Error;
use byrokrat\giroapp\Domain\State\Revoked;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Workflow\Transitions;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\autogiro\Tree\Node;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;

class AutogiroVisitor extends Visitor
{
    use DependencyInjection\CommandBusProperty;
    use DependencyInjection\DispatcherProperty;
    use DependencyInjection\DonorQueryProperty;

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
            // Hard failure, implicit rollback
            throw new InvalidAutogiroFileException(
                sprintf(
                    'File contains invalid payee BGC customer number, found: %s, expexting: %s',
                    $payeeBgcNr,
                    $this->orgBgcNr->getValue()
                )
            );
        }

        if ($payeeBankgiro && !$payeeBankgiro->equals($this->orgBankgiro)) {
            // Hard failure, implicit rollback
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
        $donor = $this->readDonor($node->getValueFrom('PayerNumber'));

        if (!$donor) {
            return;
        }

        /** @var ?IdInterface $nodeId */
        $nodeId = $node->getChild('StateId')->getValueFrom('Object');

        if ($nodeId) {
            $this->validateDonorId($nodeId, $donor);
        }

        /** @var ?AccountNumber $nodeAccount */
        $nodeAccount = $node->getChild('Account')->getValueFrom('Object');

        if ($nodeAccount) {
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

        // Hard failure, implicit rollback
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
        $donor = $this->readDonor($node->getValueFrom('PayerNumber'));

        if (!$donor) {
            return;
        }

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
        $donor = $this->readDonor($node->getValueFrom('PayerNumber'));

        if (!$donor) {
            return;
        }

        /** @var \DateTimeImmutable $date */
        $date = $node->getChild('Date')->getValueFrom('Object');

        $this->commandBus->handle(
            new AttemptState(
                $donor,
                Transitions::IMPORT_TRANSACTION_ACTIVE,
                'Transaction active on ' . $date->format('Y-m-d')
            )
        );

        /** @var \Money\Money $amount */
        $amount = $node->getChild('Amount')->getValueFrom('Object');

        $eventClassName = $success ? Event\TransactionPerformed::class : Event\TransactionFailed::class;

        $this->dispatcher->dispatch(new $eventClassName($donor, $amount, $date));
    }

    private function readDonor(string $payerNumber): ?Donor
    {
        try {
            return $this->donorQuery->requireByPayerNumber($payerNumber);
        } catch (DonorDoesNotExistException $exception) {
            // Dispatching error means that failure can be picked up in an outer layer
            $this->dispatcher->dispatch(
                new Event\ErrorEvent(
                    "{$exception->getMessage()}",
                    ['payer_number' => $payerNumber]
                )
            );
        }

        return null;
    }

    private function validateDonorAccountNumber(AccountNumber $nodeAccount, Donor $donor): void
    {
        if (!$nodeAccount->equals($donor->getAccount())) {
            // Dispatching error means that failure can be picked up in an outer layer
            $this->dispatcher->dispatch(
                new Event\ErrorEvent(
                    sprintf(
                        "Invalid mandate response for payer number '%s', found account '%s', expecting '%s'",
                        $donor->getPayerNumber(),
                        $nodeAccount->getNumber(),
                        $donor->getAccount()->getNumber()
                    ),
                    ['payer_number' => $donor->getPayerNumber(), 'mandate_key' => $donor->getMandateKey()]
                )
            );
        }
    }

    private function validateDonorId(IdInterface $nodeId, Donor $donor): void
    {
        if ($nodeId->format('S-sk') != $donor->getDonorId()->format('S-sk')) {
            // Dispatching error means that failure can be picked up in an outer layer
            $this->dispatcher->dispatch(
                new Event\ErrorEvent(
                    sprintf(
                        "Invalid mandate response for payer number '%s', found donor id '%s', expecting '%s'",
                        $donor->getPayerNumber(),
                        $nodeId->format('S-sk'),
                        $donor->getDonorId()->format('S-sk')
                    ),
                    ['payer_number' => $donor->getPayerNumber(), 'mandate_key' => $donor->getMandateKey()]
                )
            );
        }
    }
}
