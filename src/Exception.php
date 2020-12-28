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

namespace byrokrat\giroapp;

/**
 * Exception flag interface and collection of app error codes
 */
interface Exception
{
    public const GENERIC_ERROR = 1;
    public const DONOR_DOES_NOT_EXIST_EXCEPTION = 111;
    public const DONOR_ALREADY_EXISTS_EXCEPTION = 112;
    public const FILE_ALREADY_IMPORTED_EXCEPTION = 120;
    public const INVALID_AUTOGIRO_FILE_EXCEPTION = 131;
    public const INVALID_CONFIG_EXCEPTION = 132;
    public const INVALID_DATA_EXCEPTION = 133;
    public const INVALID_PLUGIN_EXCEPTION = 134;
    public const INVALID_STATE_TRANSITION_EXCEPTION = 135;
    public const INVALID_STATISTIC_EXCEPTION = 141;
    public const INVALID_XML_EXCEPTION = 136;
    public const RUNTIME_EXCEPTION = 10;
    public const UNABLE_TO_READ_FILE_EXCEPTION = 137;
    public const UNKNOWN_FILE_EXCEPTION = 138;
    public const UNKNOWN_IDENTIFIER_EXCEPTION = 139;
    public const UNSUPPORTED_VERSION_EXCEPTION = 140;
    public const VALIDATOR_EXCEPTION = 101;

    /** @return string */
    public function getMessage();

    /** @return mixed */
    public function getCode();
}
