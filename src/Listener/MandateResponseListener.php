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
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\giroapp\Model\DonorState\MandateSentState;
use byrokrat\giroapp\Model\DonorState\MandateApprovedState;
use byrokrat\giroapp\Model\DonorState\InactiveState;
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

        // TODO är har jag börjat använda findByActivePayerNumber..
        // men det kräver på något sätt att det bara kan finnas ett aktivt payer number...
        // det måste göras någon form av kontroll av detta när nya medgivanden skrivs till databasen...
        //
        // $donorMapper->has($donor); // kan behövs??
        //
        // Eller framförallt handlar det om att göra någon avancerad defensiv kontroll...
        //
        // fundera.. Issue i github??
        //
        // Vad betyder active? Att status är annat än inactive??

        $donor = $this->donorMapper->findByActivePayerNumber(
            $node->getChild('payer_number')->getValue()
        );

        // TODO om jag kastar massa undantag varje gång något är fel
        // så kommer jag aldrig att kunna processa andra noder som innehåller korrekta saker...
        // alltså förbud mot att kasta undantag


        // TODO det här är fel, om mandate exempelvis är deleted av payer så kommer
        // state att vara något annat.. Alltså ska detta vara en egen valideringsfunkion..
        //
        // $this->inState(MandateSentState::CLASS, $donor);
        /*
            // Vill jag skriva det såhär???
            // Ja det är en bra ide. Implementera på en gång. Det kan behövas även på andra ställen...
            if (!$donor->inState(MandateSentState::CLASS)) {
            }
        */
        // fundera över vid vilka situationer nedad som assertState() kan vara aktuellt...
        if (!$donor->getState() instanceof MandateSentState::CLASS) {
            $dispatcher->dispatch(
                Events::ERROR_EVENT,
                new LogEvent("Unexpected mandate response ... TODO")
            );
            return;
        }
        //
        //
        //


        $infoCode = $node->getChild('info')->getValue();

        $donorEvent = new DonorEvent(
            sprintf(
                '%s (%s)',
                Messages::MESSAGE_MAP[$infoCode] ?? '',
                Messages::MESSAGE_MAP[$node->getChild('comment')->getValue()] ?? ''
            ),
            $donor
        );

        switch ($infoCode) {
            case Messages::MANDATE_DELETED_BY_PAYER:
                $this->validateDonorIdAndAccount($donor, $node);
                // intentional fall-through to revoke mandate
            case Messages::MANDATE_DELETED_BY_RECIPIENT:
            case Messages::MANDATE_DELETED_DUE_TO_CLOSED_RECIPIENT_BG:
            case Messages::MANDATE_DELETED_DUE_TO_CLOSED_PAYER_BG:
                $donor->setState(new InactiveState);
                $dispatcher->dispatch(Events::MANDATE_REVOKED_EVENT, $donorEvent);
                break;

            case Messages::MANDATE_CREATED_BY_RECIPIENT:
                $this->validateDonorIdAndAccount($donor, $node);
                $donor->setState(new MandateApprovedState);
                $dispatcher->dispatch(Events::MANDATE_APPROVED_EVENT, $donorEvent);
                break;

            case Messages::MANDATE_UPDATED_PAYER_NUMBER_BY_RECIPIENT:
                $this->validateDonorIdAndAccount($donor, $node);
                // TODO add mandateKey eller vad som helst till meddelande...
                $dispatcher->dispatch(
                    Events::ERROR_EVENT,
                    new LogEvent('Found an update payer number post, not supported by giroapp.')
                );
                return;

            case Messages::MANDATE_ACCOUNT_RESPONSE_FROM_BANK:
            case Messages::MANDATE_DELETED_DUE_TO_UNANSWERED_ACCOUNT_REQUEST:
                $this->validateDonorIdAndAccount($donor, $node);
                // TODO ErrorState hör detta. Något som gått utanför ramen och behöver fixxas...
                // japp det är en riktigt bra idé!
                $donor->setState(new InactiveState);
                $dispatcher->dispatch(Events::MANDATE_INVALID_EVENT, $donorEvent);
                break;

            default:
                $dispatcher->dispatch(
                    Events::ERROR_EVENT,
                    new LogEvent("Invalid mandate response info code: $infoCode")
                );
                return;
        }

        $this->donorMapper->save($donor);
    }

    private function validateDonorIdAndAccount(Donor $donor, Node $node)
    {
        // TODO kan inte detta helt enkelt göras ifall attribute finns...
        // hur ser trädet ut ifall node inte innehåller id/account???
        // jag tror att det blir mer hållbart i längden..

        // TODO finns det något som motsvarar equals för id??
        if ($donor->getDonorId() != $node->getChild('id')->getAttribute('id')) {
            // TODO ett trivsamt felmeddelande!
            throw new \RuntimeException();
        }

        if (!$donor->getAccount()->equals($node->getChild('account')->getAttribute('account'))) {
            // TODO ett trivsamt felmeddelande!
            throw new \RuntimeException();
        }
    }
}
