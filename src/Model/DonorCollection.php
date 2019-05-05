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

declare(strict_types = 1);

namespace byrokrat\giroapp\Model;

use byrokrat\giroapp\Filter\FilterInterface;
use byrokrat\giroapp\Sorter\SorterInterface;

class DonorCollection implements \IteratorAggregate
{
    /**
     * @var callable
     */
    private $factory;

    /**
     * If created with a callable it must itself return a donor iterator
     *
     * @param iterable<Donor>|callable $donors
     */
    public function __construct($donors)
    {
        if (is_callable($donors)) {
            $this->factory = $donors;
            return;
        }

        if (is_iterable($donors)) {
            $this->factory = function () use ($donors) {
                foreach ($donors as $donor) {
                    yield $donor;
                }
            };
            return;
        }

        throw new \InvalidArgumentException('Invalid DonorCollection argument');
    }

    /**
     * @return iterable<Donor>
     */
    public function getIterator(): iterable
    {
        return ($this->factory)();
    }

    public function filter(FilterInterface $filter): DonorCollection
    {
        return new DonorCollection(function () use ($filter) {
            foreach ($this->getIterator() as $donor) {
                if ($filter->filterDonor($donor)) {
                    yield $donor;
                }
            }
        });
    }

    public function sort(SorterInterface $sorter): DonorCollection
    {
        $donors = iterator_to_array($this);
        usort($donors, [$sorter, 'compareDonors']);
        return new DonorCollection($donors);
    }
}
