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

namespace byrokrat\giroapp\Filter;

/**
 * Filter repository
 */
class FilterContainer
{
    /**
     * @var FilterInterface[]
     */
    private $filters = [];

    public function __construct()
    {
        $this->addFilter(new ActiveFilter);
        $this->addFilter(new InactiveFilter);
        $this->addFilter(new ExportableFilter);
        $this->addFilter(new ErrorFilter);
        $this->addFilter(new PausedFilter);
        $this->addFilter(new PurgeableFilter);
        $this->addFilter(new AwaitingResponseFilter);
    }

    public function addFilter(FilterInterface $filter): void
    {
        $this->filters[$filter->getName()] = $filter;
    }

    public function getFilter(string $name): FilterInterface
    {
        if (!isset($this->filters[$name])) {
            throw new \RuntimeException("Filter $name does not exist");
        }

        return $this->filters[$name];
    }

    public function getFilterNames(): array
    {
        return array_keys($this->filters);
    }
}
