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
     * A file imported, expects an FileEvent
     */
    const FILE_IMPORTED = 'FILE_IMPORTED';

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
     * A mandate response received from bank, expects a NodeEvent
     */
    const MANDATE_RESPONSE_RECEIVED = 'MANDATE_RESPONSE_RECEIVED';
}
