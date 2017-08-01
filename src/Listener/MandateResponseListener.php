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
use byrokrat\giroapp\Model\DonorState\MandateApprovedState;
use byrokrat\giroapp\Model\DonorState\InactiveState;
use byrokrat\giroapp\Model\DonorState\ErrorState;
use byrokrat\autogiro\Messages;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Add or reject mandates based on autogiro response
 */
class MandateResponseListener
{
    /**
     * @var DonorMapper
     */
    private $donorMapper;

    public function __construct(DonorMapper $donorMapper)
    {
        $this->donorMapper = $donorMapper;
    }

    public function __invoke(NodeEvent $nodeEvent, string $eventName, EventDispatcherInterface $dispatcher)
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
                '%s (%s)',
                $node->getChild('info')->getAttribute('message'),
                $node->getChild('comment')->getAttribute('message')
            ),
            $donor
        );

        switch ($node->getChild('info')->getAttribute('message_id')) {
            case Messages::MANDATE_DELETED_BY_PAYER:
            case Messages::MANDATE_DELETED_BY_RECIPIENT:
            case Messages::MANDATE_DELETED_DUE_TO_CLOSED_RECIPIENT_BG:
            case Messages::MANDATE_DELETED_DUE_TO_CLOSED_PAYER_BG:
                $donor->setState(new InactiveState);
                $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, $donorEvent);
                break;

            case Messages::MANDATE_CREATED_BY_RECIPIENT:
                $donor->setState(new MandateApprovedState);
                $dispatcher->dispatch(Events::MANDATE_APPROVED_EVENT, $donorEvent);
                break;

            case Messages::MANDATE_UPDATED_PAYER_NUMBER_BY_RECIPIENT:
            case Messages::MANDATE_ACCOUNT_RESPONSE_FROM_BANK:
            case Messages::MANDATE_DELETED_DUE_TO_UNANSWERED_ACCOUNT_REQUEST:
                $donor->setState(new ErrorState);
                $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, $donorEvent);
                break;

            default:
                $dispatcher->dispatch(
                    Events::WARNING_EVENT,
                    new LogEvent("Invalid mandate response info code: {$node->getChild('info')->getValue()}")
                );
                $nodeEvent->stopPropagation();
                return;
        }

        $this->donorMapper->save($donor);
    }
}
