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

namespace byrokrat\giroapp\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface for giroapp console commands
 */
interface ConsoleInterface
{
    public const OPTION_SOURCE = 'source';
    public const OPTION_ID = 'id';
    public const OPTION_PAYER_NUMBER = 'payer-number';
    public const OPTION_NEW_PAYER_NUMBER = 'new-payer-number';
    public const OPTION_STATE = 'state';
    public const OPTION_NEW_STATE = 'new-state';
    public const OPTION_ACCOUNT = 'account';
    public const OPTION_NAME = 'name';
    public const OPTION_AMOUNT = 'amount';
    public const OPTION_NEW_AMOUNT = 'new-amount';
    public const OPTION_ADDRESS = 'address';
    public const OPTION_ADDRESS1 = 'address1';
    public const OPTION_ADDRESS2 = 'address2';
    public const OPTION_ADDRESS3 = 'address3';
    public const OPTION_POSTAL_CODE = 'postal-code';
    public const OPTION_POSTAL_CITY = 'postal-city';
    public const OPTION_EMAIL = 'email';
    public const OPTION_PHONE = 'phone';
    public const OPTION_COMMENT = 'comment';
    public const OPTION_ATTR_KEY = 'attr-key';
    public const OPTION_ATTR_VALUE = 'attr-value';

    public const OPTION_DESCS = [
        self::OPTION_SOURCE => 'Mandate source',
        self::OPTION_ID => 'Personal id',
        self::OPTION_PAYER_NUMBER => 'Payer number',
        self::OPTION_NEW_PAYER_NUMBER => 'New payer number',
        self::OPTION_STATE => 'Donor state identifier',
        self::OPTION_NEW_STATE => 'New donor state identifier',
        self::OPTION_ACCOUNT => 'Account number',
        self::OPTION_NAME => 'Name',
        self::OPTION_AMOUNT => 'Monthly donation amount',
        self::OPTION_NEW_AMOUNT => 'New monthly donation amount',
        self::OPTION_ADDRESS => 'Postal address',
        self::OPTION_ADDRESS1 => 'Postal address line 1',
        self::OPTION_ADDRESS2 => 'Postal address line 2',
        self::OPTION_ADDRESS3 => 'Postal address line 3',
        self::OPTION_POSTAL_CODE => 'Postal code',
        self::OPTION_POSTAL_CITY => 'Postal city',
        self::OPTION_EMAIL => 'Contact email address',
        self::OPTION_PHONE => 'Contact phone number',
        self::OPTION_COMMENT => 'Comment',
        self::OPTION_ATTR_KEY => 'Attribute key',
        self::OPTION_ATTR_VALUE => 'Attribute value',
    ];

    public function configure(Command $command): void;

    public function execute(InputInterface $input, OutputInterface $output): void;
}
