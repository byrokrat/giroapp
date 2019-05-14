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

interface Events
{
    /**
     * Execution about to start, expects a LogEvent
     */
    const EXECUTION_STARTED = 'EXECUTION_STARTED';

    /**
     * Execution about to end, expects a LogEvent
     */
    const EXECUTION_STOPED = 'EXECUTION_STOPED';

    /**
     * A file imported, expects an FileEvent
     */
    const FILE_IMPORTED = 'FILE_IMPORTED';

    /**
     * A file exported, expects an FileEvent
     */
    const FILE_EXPORTED = 'FILE_EXPORTED';

    /**
     * A file forcefully imported, expects an FileEvent
     */
    const FILE_FORCEFULLY_IMPORTED = 'FILE_FORCEFULLY_IMPORTED';

    /**
     * An autogiro file imported, expects an FileEvent
     */
    const AUTOGIRO_FILE_IMPORTED = 'AUTOGIRO_FILE_IMPORTED';

    /**
     * An XML file imported, expects an XmlEvent
     */
    const XML_FILE_IMPORTED = 'XML_FILE_IMPORTED';

    /**
     * A donor added, expects a DonorEvent
     */
    const DONOR_ADDED = 'DONOR_ADDED';

    /**
     * A donor updated, expects a DonorEvent
     */
    const DONOR_UPDATED = 'DONOR_UPDATED';

    /**
     * A mandate response received from bank, expects a NodeEvent
     */
    const MANDATE_RESPONSE_RECEIVED = 'MANDATE_RESPONSE_RECEIVED';

    /**
     * A mandate approved by the bank, expects a DonorEvent
     */
    const MANDATE_APPROVED = 'MANDATE_APPROVED';

    /**
     * A mandate revoked, expects a DonorEvent
     */
    const MANDATE_REVOKED = 'MANDATE_REVOKED';

    /**
     * Mandate revocation requested, expects a DonorEvent
     */
    const MANDATE_REVOCATION_REQUESTED = 'MANDATE_REVOCATION_REQUESTED';

    /**
     * A mandate is invalid and could not be approved, expects a DonorEvent
     */
    const MANDATE_INVALIDATED = 'MANDATE_INVALIDATED';

    /**
     * A mandate pause has been requested, expects a DonorEvent
     */
    const MANDATE_PAUSE_REQUESTED = 'MANDATE_PAUSE_REQUESTED';

    /**
     * A mandate has been paused, expects a DonorEvent
     */
    const MANDATE_PAUSED = 'MANDATE_PAUSED';

    /**
     * A mandate has been restarted, expects a DonorEvent
     */
    const MANDATE_RESTARTED = 'MANDATE_RESTARTED';

    /**
     * An unexpected and unrecoverable error, expects a LogEvent
     */
    const ERROR = 'ERROR';

    /**
     * An unexpected but recoverable situation, expects a LogEvent
     */
    const WARNING = 'WARNING';

    /**
     * Present information to user, expects a LogEvent
     */
    const INFO = 'INFO';

    /**
     * Present debug information to user, expects a LogEvent
     */
    const DEBUG = 'DEBUG';
}
