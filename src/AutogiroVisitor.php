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

namespace byrokrat\giroapp;

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\autogiro\Tree\Node;
use byrokrat\autogiro\Tree\Record\OpeningRecordNode;
use byrokrat\autogiro\Tree\Record\Request\RequestOpeningRecordNode;
use byrokrat\autogiro\Tree\Record\Response\MandateResponseNode;
use byrokrat\banking\Bankgiro;

/**
 * Giroapp visitor of autogiro files
 */
class AutogiroVisitor extends Visitor
{
    use DispatcherProperty;

    /**
     * @var string
     */
    private $orgBgcNr;

    /**
     * @var Bankgiro
     */
    private $orgBankgiro;

    public function __construct(string $orgBgcNr, Bankgiro $orgBankgiro)
    {
        $this->orgBgcNr = $orgBgcNr;
        $this->orgBankgiro = $orgBankgiro;
    }

    public function beforeMandateResponseNode(MandateResponseNode $node): void
    {
        $this->dispatcher->dispatch(Events::MANDATE_RESPONSE_RECEIVED, new NodeEvent($node));
    }

    public function beforeOpeningRecordNode(OpeningRecordNode $node): void
    {
        $this->validateOpeningNode($node);
    }

    public function beforeRequestOpeningRecordNode(RequestOpeningRecordNode $node): void
    {
        $this->validateOpeningNode($node);
    }

    private function validateOpeningNode(Node $node): void
    {
        /** @var string $payeeBgcNr */
        $payeeBgcNr = $node->getChild('payee_bgc_number')->getValue();

        /** @var Bankgiro $payeeBankgiro */
        $payeeBankgiro = $node->getChild('payee_bankgiro')->getAttribute('account');

        if ($payeeBgcNr != $this->orgBgcNr) {
            throw new \RuntimeException('File contains invalid payee BGC customer number');
        }

        if (!$payeeBankgiro->equals($this->orgBankgiro)) {
            throw new \RuntimeException('File contains invalid payee bankgiro account number');
        }
    }
}
