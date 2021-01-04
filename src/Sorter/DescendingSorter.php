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

declare(strict_types=1);

namespace byrokrat\giroapp\Sorter;

use byrokrat\giroapp\Domain\Donor;

final class DescendingSorter implements SorterInterface
{
    /** @var SorterInterface */
    private $wrapped;

    public function __construct(SorterInterface $wrapped)
    {
        $this->wrapped = $wrapped;
    }

    public function getName(): string
    {
        return '';
    }

    public function compareDonors(Donor $left, Donor $right): int
    {
        return $this->wrapped->compareDonors($left, $right) * -1;
    }
}
