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

use byrokrat\giroapp\State;

/**
 * Donor state identifiers
 */
interface States
{
    /**
     * Donor is active
     */
    const ACTIVE = 'ACTIVE';

    /**
     * Donor is inactive due to an error
     */
    const ERROR = 'ERROR';

    /**
     * Donor is inactive (has been revoked/rejected)
     */
    const INACTIVE = 'INACTIVE';

    /**
     * A mandate has been received from the donor
     */
    const NEW_MANDATE = 'NEW_MANDATE';

    /**
     * A digital mandate has been received from the bank
     */
    const NEW_DIGITAL_MANDATE = 'NEW_DIGITAL_MANDATE';

    /**
     * Mandate has been sent to the bank and is awaiting approval
     */
    const MANDATE_SENT = 'MANDATE_SENT';

    /**
     * Mandate has been approved by the bank
     */
    const MANDATE_APPROVED = 'MANDATE_APPROVED';

    /**
     * Mandate is awaiting revocation
     */
    const REVOKE_MANDATE = 'REVOKE_MANDATE';

    /**
     * Revocation request has been sent to the bank
     */
    const REVOCATION_SENT = 'REVOCATION_SENT';
}
