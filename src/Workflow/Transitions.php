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

namespace byrokrat\giroapp\Workflow;

interface Transitions
{
    /**
     * Export mandate to BGC
     */
    const EXPORT = 'EXPORT';

    /**
     * Start the cycle of pausing a mandate
     */
    const INITIATE_PAUSE = 'INITIATE_PAUSE';

    /**
     * Start the cycle of restarting a paused mandate
     */
    const INITIATE_RESTART = 'INITIATE_RESTART';

    /**
     * Start the cycle of mandate revocation
     */
    const INITIATE_REVOCATION = 'INITIATE_REVOCATION';

    /**
     * Mark mandate as registered with the bank
     */
    const MARK_MANDATE_REGISTERED = 'MARK_MANDATE_REGISTERED';

    /**
     * Mark mandate as revoked
     */
    const MARK_MANDATE_REVOKED = 'MARK_MANDATE_REVOKED';

    /**
     * Mark mandate as removed
     */
    const MARK_MANDATE_REMOVED = 'MARK_MANDATE_REMOVED';

    /**
     * Mark transaction as active
     */
    const MARK_TRANSACTION_ACTIVE = 'MARK_TRANSACTION_ACTIVE';

    /**
     * Mark transaction as removed
     */
    const MARK_TRANSACTION_REMOVED = 'MARK_TRANSACTION_REMOVED';
}
