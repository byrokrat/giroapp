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

namespace byrokrat\giroapp;

/**
 * Exception flag interface and collection of app error codes
 *
 * NOTE that error codes and exceptions may change without warning before version 1.0.0
 */
interface Exception
{
    const GENERIC_ERROR = 1;
    const DONOR_DOES_NOT_EXIST_EXCEPTION = 111;
    const DONOR_ALREADY_EXISTS_EXCEPTION = 112;
    const FILE_ALREADY_IMPORTED_EXCEPTION = 120;
    const INVALID_AUTOGIRO_FILE_EXCEPTION = 210;
    const INVALID_CONFIG_EXCEPTION = 220;
    const INVALID_DATA_EXCEPTION = 101;
    const INVALID_PLUGIN_EXCEPTION = 230;
    const INVALID_STATE_TRANSITION_EXCEPTION = 250;
    const INVALID_XML_EXCEPTION = 240;
    const INVALID_XML_FORM_EXCEPTION = 241;
    const UNABLE_TO_BUILD_DONOR_EXCEPTION = 302;
    const UNABLE_TO_READ_FILE_EXCEPTION = 301;
    const UNKNOWN_IDENTIFIER_EXCEPTION = 102;
    const UNSUPPORTED_VERSION_EXCEPTION = 104;
    const VALIDATOR_EXCEPTION = 103;
}
