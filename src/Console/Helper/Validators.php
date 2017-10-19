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

namespace byrokrat\giroapp\Console\Helper;

use byrokrat\amount\Currency\SEK;
use byrokrat\banking\AccountFactory;
use byrokrat\banking\BankgiroFactory;
use byrokrat\id\IdFactory;
use hanneskod\clean\Rule;

/**
 * Collection of input validators
 */
class Validators
{
    /**
     * @var BankgiroFactory
     */
    private $bankgiroFactory;

    /**
     * @var AccountFactory
     */
    private $accountFactory;

    /**
     * @var IdFactory
     */
    private $idFactory;

    public function __construct(AccountFactory $accountFactory, BankgiroFactory $bankgiroFactory, IdFactory $idFactory)
    {
        $this->accountFactory = $accountFactory;
        $this->bankgiroFactory = $bankgiroFactory;
        $this->idFactory = $idFactory;
    }

    public function getAmountValidator(): callable
    {
        return (new Rule)->msg('Amount must be a numerical value')
            ->match('ctype_digit')
            ->post(function ($val) {
                return new SEK($val);
            });
    }

    public function getAccountValidator(): callable
    {
        return (new Rule)->msg('Valid account number required')->post([$this->accountFactory, 'createAccount']);
    }

    public function getBankgiroValidator(): callable
    {
        return (new Rule)->msg('Valid bankgiro number required')->post([$this->bankgiroFactory, 'createAccount']);
    }

    public function getIdValidator(): callable
    {
        return (new Rule)->msg('Valid id required')->post([$this->idFactory, 'create']);
    }

    public function getBgcCustomerNumberValidator(): callable
    {
        return (new Rule)->msg('BGC customer number must be a 6 digit number')
            ->match('ctype_digit')
            ->match(function ($val) {
                return strlen($val) == 6;
            });
    }

    public function getPayerNumberValidator(): callable
    {
        return (new Rule)->msg('Payer number must be numerical and max 16 digits')
            ->match('ctype_digit')
            ->match(function ($val) {
                return strlen($val) <= 16;
            });
    }

    public function getEmailValidator(): callable
    {
        return (new Rule)->msg('Email address must be valid')->match(function ($val) {
            return empty($val) || filter_var($val, FILTER_VALIDATE_EMAIL);
        });
    }

    public function getPhoneValidator(): callable
    {
        return (new Rule)->msg('Phone number must be valid')->match(function ($val) {
            return !!preg_match('/^\+?[0-9()., -]*$/', $val);
        });
    }

    public function getPostalCodeValidator(): callable
    {
        return (new Rule)->msg('Pustal code must be numerical')->pre(function ($val) {
            return str_replace(' ', '', $val);
        })->match(function ($val) {
            return empty($val) || ctype_digit($val);
        });
    }

    public function getStringFilter(): callable
    {
        return (new Rule)->pre(function ($val) {
            return filter_var(
                $val,
                FILTER_UNSAFE_RAW,
                FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK
            );
        });
    }

    public function getRequiredStringValidator(string $field): callable
    {
        return (new Rule)->msg("$field: empty value not allowed")->pre(function ($val) {
            return filter_var(
                $val,
                FILTER_UNSAFE_RAW,
                FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK
            );
        })->match(function ($val) {
            return !empty($val);
        });
    }
}
