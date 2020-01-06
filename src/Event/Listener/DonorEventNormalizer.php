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
 * Copyright 2016-20 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\DonorAdded;
use byrokrat\giroapp\Event\DonorAmountUpdated;
use byrokrat\giroapp\Event\DonorAttributeUpdated;
use byrokrat\giroapp\Event\DonorCommentUpdated;
use byrokrat\giroapp\Event\DonorEmailUpdated;
use byrokrat\giroapp\Event\DonorNameUpdated;
use byrokrat\giroapp\Event\DonorPayerNumberUpdated;
use byrokrat\giroapp\Event\DonorPhoneUpdated;
use byrokrat\giroapp\Event\DonorPostalAddressUpdated;
use byrokrat\giroapp\Event\DonorRemoved;
use byrokrat\giroapp\Event\DonorStateUpdated;
use byrokrat\giroapp\Event\TransactionEvent;

class DonorEventNormalizer
{
    use DependencyInjection\MoneyFormatterProperty;

    /**
     * @return array<string, mixed>
     */
    public function normalizeEvent(DonorEvent $event): array
    {
        switch (true) {
            case $event instanceof DonorAdded:
                $donor = $event->getDonor();
                return [
                    'mandate_key' => $donor->getMandateKey(),
                    'state' => $donor->getState()->getStateId(),
                    'mandate_source' => $donor->getMandateSource(),
                    'payer_number' => $donor->getPayerNumber(),
                    'account' => $donor->getAccount()->getNumber(),
                    'donor_id' => $donor->getDonorId()->format('S-sk'),
                    'name' => $donor->getName(),
                    'address' => [
                        'line1' => $donor->getPostalAddress()->getLine1(),
                        'line2' => $donor->getPostalAddress()->getLine2(),
                        'line3' => $donor->getPostalAddress()->getLine3(),
                        'postal_code' => $donor->getPostalAddress()->getPostalCode(),
                        'postal_city' => $donor->getPostalAddress()->getPostalCity(),
                    ],
                    'email' => $donor->getEmail(),
                    'phone' => $donor->getPhone(),
                    'donation_amount' => $this->moneyFormatter->format($donor->getDonationAmount()),
                    'comment' => $donor->getComment(),
                    'attributes' => $donor->getAttributes(),
                ];
            case $event instanceof DonorAmountUpdated:
                return [
                    'donation_amount' => $this->moneyFormatter->format($event->getNewAmount()),
                ];
            case $event instanceof DonorAttributeUpdated:
                return [
                    'attributes' => [
                        $event->getAttributeKey() => $event->getAttributeValue(),
                    ]
                ];
            case $event instanceof DonorCommentUpdated:
                return [
                    'comment' => $event->getNewComment(),
                ];
            case $event instanceof DonorEmailUpdated:
                return [
                    'email' => $event->getNewEmail(),
                ];
            case $event instanceof DonorNameUpdated:
                return [
                    'name' => $event->getNewName(),
                ];
            case $event instanceof DonorPayerNumberUpdated:
                return [
                    'payer_number' => $event->getNewPayerNumber(),
                    'payer_number_update_description' => $event->getUpdateDescription(),
                ];
            case $event instanceof DonorPhoneUpdated:
                return [
                    'phone' => $event->getNewPhone(),
                ];
            case $event instanceof DonorPostalAddressUpdated:
                $address = $event->getNewPostalAddress();
                return [
                    'address' => [
                        'line1' => $address->getLine1(),
                        'line2' => $address->getLine2(),
                        'line3' => $address->getLine3(),
                        'postal_code' => $address->getPostalCode(),
                        'postal_city' => $address->getPostalCity(),
                    ],
                ];
            case $event instanceof DonorRemoved:
                return [];
            case $event instanceof DonorStateUpdated:
                return [
                    'state' => $event->getNewState()->getStateId(),
                    'state_update_description' => $event->getUpdateDescription(),
                ];
            case $event instanceof TransactionEvent:
                return [
                    'transaction_amount' => $this->moneyFormatter->format($event->getTransactionAmount()),
                    'transaction_date' => $event->getDate()->format('Y-m-d'),
                ];
        }

        throw new \LogicException("Unable to normalize event, unknown event type " . get_class($event));
    }
}
