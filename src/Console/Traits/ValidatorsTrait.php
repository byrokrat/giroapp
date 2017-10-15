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

namespace byrokrat\giroapp\Console\Traits;

use byrokrat\banking\BankgiroFactory;
use byrokrat\id\IdFactory;
use hanneskod\clean\Rule;

/**
 * Collection of input validators
 */
trait ValidatorsTrait
{
    /**
     * @var BankgiroFactory
     */
    private $bankgiroFactory;

    /**
     * @var IdFactory
     */
    private $idFactory;

    /**
     * @required
     */
    public function setBankgiroFactory(BankgiroFactory $bankgiroFactory): void
    {
        $this->bankgiroFactory = $bankgiroFactory;
    }

    /**
     * @required
     */
    public function setIdFactory(IdFactory $idFactory): void
    {
        $this->idFactory = $idFactory;
    }

    protected function getOrganizationNumberValidator(): Rule
    {
        return (new Rule)->msg('Not a valid organization number')->post([$this->idFactory, 'create']);
    }

    protected function getBankgiroValidator(): Rule
    {
        return (new Rule)->msg('Not a valid bankgiro number')->post([$this->bankgiroFactory, 'createAccount']);
    }

    protected function getBgcCustomerNumberValidator(): Rule
    {
        return (new Rule)->msg('Value must be a 6 digit number')
            ->match('ctype_digit')
            ->match(function ($val) {
                return strlen($val) == 6;
            });
    }
}
