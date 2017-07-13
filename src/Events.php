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

namespace byrokrat\giroapp;

/**
 * List of giroapp event names
 */
interface Events
{
    /**
     * Execution about to start
     */
    const EXECUTION_START_EVENT = 'execution.start';

    /**
     * Execution about to end
     */
    const EXECUTION_END_EVENT = 'execution.end';

    /**
     * A bank file imported, expects an ImportEvent
     */
    const IMPORT_EVENT = 'file.import';

    /**
     * A mandate response received from bank, expects a NodeEvent
     */
    const MANDATE_RESPONSE_EVENT = 'mandate.response';

    /**
     * Present information to user, expects a LogEvent
     */
    const INFO_EVENT = 'INFO';

    /**
     * A ecoverable but unexpected situation, expects a LogEvent
     */
    const NOTICE_EVENT = 'NOTICE';

    /**
     * A serious error, expects a LogEvent
     */
    const ERROR_EVENT = 'ERROR';
}
