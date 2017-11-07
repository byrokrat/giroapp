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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Listener;

use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\State\StatePool;
use byrokrat\giroapp\States;
use byrokrat\autogiro\Messages;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Dispatcher;

/**
 * Add or reject mandates based on autogiro response
 */
class MandateResponseListener
{
    /**
     * @var DonorMapper
     */
    private $donorMapper;

    /**
     * @var StatePool
     */
    private $statePool;

    public function __construct(DonorMapper $donorMapper, StatePool $statePool)
    {
        $this->donorMapper = $donorMapper;
        $this->statePool = $statePool;
    }

    /**
     * @scrutinizer ignore-unused $name Passed by dispatcher
     */
    public function onMandateResponseEvent(NodeEvent $nodeEvent, string $name, Dispatcher $dispatcher)
    {
        $node = $nodeEvent->getNode();

        $donor = $this->donorMapper->findByActivePayerNumber(
            $node->getChild('payer_number')->getValue()
        );

        // validate id if present in node
        if ($node->getChild('id')->hasAttribute('id')) {
            /** @var \byrokrat\id\Id */
            $nodeId = $node->getChild('id')->getAttribute('id');

            if ($donor->getDonorId()->format('S-sk') != $nodeId->format('S-sk')) {
                $dispatcher->dispatch(
                    Events::WARNING_EVENT,
                    new LogEvent(
                        sprintf(
                            "Invalid mandate response for payer number '%s', found donor id '%s', expecting '%s'",
                            $donor->getPayerNumber(),
                            $nodeId->format('S-sk'),
                            $donor->getDonorId()->format('S-sk')
                        )
                    )
                );

                // stop processing on invalid id
                $nodeEvent->stopPropagation();
                return;
            }
        }

        // validate account if present in node
        if ($node->getChild('account')->hasAttribute('account')) {
            /** @var \byrokrat\banking\AccountNumber */
            $nodeAccount = $node->getChild('account')->getAttribute('account');

            if (!$donor->getAccount()->equals($nodeAccount)) {
                $dispatcher->dispatch(
                    Events::WARNING_EVENT,
                    new LogEvent(
                        sprintf(
                            "Invalid mandate response for payer number '%s', found account '%s', expecting '%s'",
                            $donor->getPayerNumber(),
                            $nodeAccount->getNumber(),
                            $donor->getAccount()->getNumber()
                        )
                    )
                );

                // stop processing on invalid account
                $nodeEvent->stopPropagation();
                return;
            }
        }

        $donorEvent = new DonorEvent(
            sprintf(
                '%s: %s',
                $donor->getMandateKey(),
                $node->getChild('status')->getAttribute('message')
            ),
            $donor
        );

        switch ($node->getChild('status')->getAttribute('message_id')) {
            case Messages::STATUS_MANDATE_DELETED_BY_PAYER:
            case Messages::STATUS_MANDATE_DELETED_DUE_TO_UNANSWERED_ACCOUNT_REQUEST:
            case Messages::STATUS_MANDATE_DELETED:
            case Messages::STATUS_MANDATE_DELETED_DUE_TO_CLOSED_PAYER_BG:
            case Messages::STATUS_MANDATE_DELETED_BY_BANK:
            case Messages::STATUS_MANDATE_DELETED_BY_BGC:
                $donor->setState($this->statePool->getState(States::INACTIVE));
                $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, $donorEvent);
                break;

            case Messages::STATUS_MANDATE_CREATED:
                $donor->setState($this->statePool->getState(States::MANDATE_APPROVED));
                $dispatcher->dispatch(Events::MANDATE_APPROVED_EVENT, $donorEvent);
                break;

            case Messages::STATUS_MANDATE_ACCOUNT_NOT_ALLOWED:
            case Messages::STATUS_MANDATE_DOES_NOT_EXIST:
            case Messages::STATUS_MANDATE_INVALID_ACCOUNT_OR_ID:
            case Messages::STATUS_MANDATE_PAYER_NUMBER_DOES_NOT_EXIST:
            case Messages::STATUS_MANDATE_ALREADY_EXISTS:
            case Messages::STATUS_MANDATE_INVALID_ID_OR_BG_NOT_ALLOWED:
            case Messages::STATUS_MANDATE_INVALID_PAYER_NUMBER:
            case Messages::STATUS_MANDATE_INVALID_ACCOUNT:
            case Messages::STATUS_MANDATE_INVALID_PAYEE_ACCOUNT:
            case Messages::STATUS_MANDATE_INACTIVE_PAYEE_ACCOUNT:
            case Messages::STATUS_MANDATE_BLOCKED_BY_PAYER:
            case Messages::STATUS_MANDATE_BLOCK_REMOVED:
            case Messages::STATUS_MANDATE_MAX_AMOUNT_NOT_ALLOWED:
                $donor->setState($this->statePool->getState(States::ERROR));
                $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, $donorEvent);
                break;

            default:
                $dispatcher->dispatch(
                    Events::WARNING_EVENT,
                    new LogEvent(
                        sprintf(
                            '%s: invalid mandate status code: %s',
                            $donor->getMandateKey(),
                            $node->getChild('status')->getValue()
                        )
                    )
                );
                $nodeEvent->stopPropagation();
        }
    }
}
