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

namespace byrokrat\giroapp\Xml;

use Money\MoneyParser;

/**
 * Configure compiler based on ini settings
 */
final class CompilerConfigurator
{
    public const PAYER_NR_STRATEGY_PERSONAL_ID = 'personal-id';
    public const PAYER_NR_STRATEGY_IGNORE = 'ignore';

    /** @var array<CompilerPassInterface> */
    private $compilerPasses = [];

    public function __construct(
        string $payerNrStrategy,
        string $donationAmountFromAttribute,
        string $phoneFromAttribute,
        string $emailFromAttribute,
        string $commentFromAttribute,
        MoneyParser $moneyParser
    ) {
        switch ($payerNrStrategy) {
            case self::PAYER_NR_STRATEGY_PERSONAL_ID:
                $this->compilerPasses[] = new PayerNrFromPersonalIdPass();
                break;
            case self::PAYER_NR_STRATEGY_IGNORE:
            default:
                // ignore
        }

        $this->compilerPasses[] = new DonationAmountFromAttributePass(
            $donationAmountFromAttribute,
            $moneyParser
        );

        $this->compilerPasses[] = new PhoneFromAttributePass($phoneFromAttribute);
        $this->compilerPasses[] = new EmailFromAttributePass($emailFromAttribute);
        $this->compilerPasses[] = new CommentFromAttributePass($commentFromAttribute);
    }

    public function loadCompilerPasses(XmlMandateCompiler $compiler): void
    {
        foreach ($this->compilerPasses as $compilerPass) {
            $compiler->addCompilerPass($compilerPass);
        }
    }
}
