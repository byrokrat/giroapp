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

namespace byrokrat\giroapp\Domain;

interface MandateSources
{
    /**
     * Indicator that mandate exists printed on paper
     */
    public const MANDATE_SOURCE_PAPER = 'MANDATE_SOURCE_PAPER';

    /**
     * Indicator that mandate is from an online form (eg. mandate from homepage)
     */
    public const MANDATE_SOURCE_ONLINE_FORM = 'MANDATE_SOURCE_ONLINE_FORM';

    /**
     * Indicator that mandate is digital
     */
    public const MANDATE_SOURCE_DIGITAL = 'MANDATE_SOURCE_DIGITAL';
}
