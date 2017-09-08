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

namespace byrokrat\giroapp\Xml;

/**
 * Defines the semantic content of custom data fields in xml mandates
 */
interface XmlMandateMigrationInterface
{
    /**
     * Indicator that a field contains a phone number
     */
    const PHONE = 'PHONE';

    /**
     * Indicator that a field contains an email address
     */
    const EMAIL = 'EMAIL';

    /**
     * Indicator that a field contains amount to be donated monthly
     */
    const DONATION_AMOUNT = 'DONATION_AMOUNT';

    /**
     * Indicator that a field contains a comment
     */
    const COMMENT = 'COMMENT';

    /**
     * Get a map of custom data field names to action or semantic constant
     */
    public function getXmlMigrationMap(): array;
}
