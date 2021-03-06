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
 * Copyright 2016-21 Hannes Forsgård
 */

namespace byrokrat\giroapp\Workflow;

interface Transitions
{
    /**
     * Export mandate to BGC
     */
    public const EXPORT = 'EXPORT';

    /**
     * Start the cycle of pausing a mandate
     */
    public const INITIATE_PAUSE = 'INITIATE_PAUSE';

    /**
     * Start the cycle of a payer number change
     */
    public const INITIATE_PAYER_NUMBER_CHANGE = 'INITIATE_PAYER_NUMBER_CHANGE';

    /**
     * Start the cycle of restarting a paused mandate
     */
    public const INITIATE_RESTART = 'INITIATE_RESTART';

    /**
     * Start the cycle of mandate revocation
     */
    public const INITIATE_REVOCATION = 'INITIATE_REVOCATION';

    /**
     * Start the cycle of a transaction update (new amount)
     */
    public const INITIATE_TRANSACTION_UPDATE = 'INITIATE_TRANSACTION_UPDATE';

    /**
     * Mark mandate as registered with the bank
     */
    public const IMPORT_MANDATE_REGISTERED = 'IMPORT_MANDATE_REGISTERED';

    /**
     * Mark mandate as revoked
     */
    public const IMPORT_MANDATE_REVOKED = 'IMPORT_MANDATE_REVOKED';

    /**
     * Mark transaction as active
     */
    public const IMPORT_TRANSACTION_ACTIVE = 'IMPORT_TRANSACTION_ACTIVE';

    /**
     * Mark transaction as removed
     */
    public const IMPORT_TRANSACTION_REMOVED = 'IMPORT_TRANSACTION_REMOVED';

    /**
     * Mark mandate as removed
     */
    public const REMOVE = 'REMOVE';
}
