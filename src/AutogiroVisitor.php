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

namespace byrokrat\giroapp;

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\NodeEvent;
use byrokrat\autogiro\Visitor\Visitor;
use byrokrat\autogiro\Tree\Node;
use byrokrat\banking\AccountNumber;

/**
 * Giroapp visitor of autogiro files
 */
class AutogiroVisitor extends Visitor
{
    use DispatcherProperty;

    /**
     * @var ConfigInterface
     */
    private $orgBgcNr;

    /**
     * @var AccountNumber
     */
    private $orgBankgiro;

    public function __construct(ConfigInterface $orgBgcNr, AccountNumber $orgBankgiro)
    {
        $this->orgBgcNr = $orgBgcNr;
        $this->orgBankgiro = $orgBankgiro;
    }

    public function beforeMandateResponse(Node $node): void
    {
        $this->dispatcher->dispatch(Events::MANDATE_RESPONSE_RECEIVED, new NodeEvent($node));
    }

    public function beforeOpening(Node $node): void
    {
        /** @var string $payeeBgcNr */
        $payeeBgcNr = (string)$node->getChild('PayeeBgcNumber')->getValue();

        /** @var ?AccountNumber $payeeBankgiro */
        $payeeBankgiro = $node->getChild('PayeeBankgiro')->getValueFrom('Object');

        if ($payeeBgcNr && $payeeBgcNr != $this->orgBgcNr->getValue()) {
            throw new \RuntimeException(
                sprintf(
                    'File contains invalid payee BGC customer number, found: %s, expexting: %s',
                    $payeeBgcNr,
                    $this->orgBgcNr->getValue()
                )
            );
        }

        if ($payeeBankgiro && !$payeeBankgiro->equals($this->orgBankgiro)) {
            throw new \RuntimeException(
                sprintf(
                    'File contains invalid payee bankgiro account number, found: %s, expexting: %s',
                    $payeeBankgiro->getNumber(),
                    $this->orgBankgiro->getNumber()
                )
            );
        }
    }
}
