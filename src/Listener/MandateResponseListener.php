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

namespace byrokrat\giroapp\Listener;

use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Db\DonorQueryInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\States;

/**
 * Add or reject mandates based on autogiro response
 */
class MandateResponseListener
{
    use DependencyInjection\CommandBusProperty;
    use DependencyInjection\DispatcherProperty;
    use DependencyInjection\DonorQueryProperty;

    public function onMandateResponseReceived(NodeEvent $nodeEvent): void
    {
        $node = $nodeEvent->getNode();

        $donor = $this->donorQuery->requireByPayerNumber(
            $node->getValueFrom('PayerNumber')
        );

        /** @var \byrokrat\id\IdInterface $nodeId */
        if ($nodeId = $node->getChild('StateId')->getValueFrom('Object')) {
            if ($donor->getDonorId()->format('S-sk') != $nodeId->format('S-sk')) {
                $this->dispatcher->dispatch(
                    Events::WARNING,
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

        /** @var \byrokrat\banking\AccountNumber $nodeAccount */
        if ($nodeAccount = $node->getChild('Account')->getValueFrom('Object')) {
            if (!$donor->getAccount()->equals($nodeAccount)) {
                $this->dispatcher->dispatch(
                    Events::WARNING,
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

        if ($node->hasChild('CreatedFlag')) {
            $this->commandBus->handle(new UpdateState($donor, States::MANDATE_APPROVED));
            return;
        }

        if ($node->hasChild('DeletedFlag')) {
            $this->commandBus->handle(new UpdateState($donor, States::INACTIVE));
            return;
        }

        if ($node->hasChild('ErrorFlag')) {
            $this->commandBus->handle(new UpdateState($donor, States::ERROR));
            return;
        }

        $this->dispatcher->dispatch(
            Events::WARNING,
            new LogEvent(
                sprintf(
                    '%s: invalid mandate status code: %s',
                    $donor->getMandateKey(),
                    (string)$node->getChild('Status')->getValueFrom('Number')
                )
            )
        );

        $nodeEvent->stopPropagation();
    }
}
