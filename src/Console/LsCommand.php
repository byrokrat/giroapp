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

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DonorMapperProperty;
use byrokrat\giroapp\Filter\FilterCollection;
use byrokrat\giroapp\Filter\CombinedFilter;
use byrokrat\giroapp\Formatter\FormatterCollection;
use byrokrat\giroapp\Sorter\SorterCollection;
use byrokrat\giroapp\Sorter\DescendingSorter;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LsCommand implements CommandInterface
{
    use DonorMapperProperty;

    /** @var FilterCollection */
    private $filterCollection;

    /** @var FormatterCollection */
    private $formatterCollection;

    /** @var SorterCollection */
    private $sorterCollection;

    public function __construct(
        FilterCollection $filterCollection,
        FormatterCollection $formatterCollection,
        SorterCollection $sorterCollection
    ) {
        $this->filterCollection = $filterCollection;
        $this->formatterCollection = $formatterCollection;
        $this->sorterCollection = $sorterCollection;
    }

    public function configure(Adapter $adapter): void
    {
        $adapter->setName('ls');
        $adapter->setDescription('List donors');
        $adapter->setHelp('List donors in database');

        $adapter->addOption(
            'filter',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            sprintf(
                'Use donor filter, possible values: %s',
                implode(", ", $this->filterCollection->getItemKeys())
            )
        );

        $adapter->addOption(
            'filter-not',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            sprintf(
                'Use negated filter, possible values: %s',
                implode(", ", $this->filterCollection->getItemKeys())
            )
        );

        $adapter->addOption(
            'sorter',
            null,
            InputOption::VALUE_REQUIRED,
            sprintf(
                'Set donor sorter, possible values: %s',
                implode(", ", $this->sorterCollection->getItemKeys())
            ),
            ''
        );

        $adapter->addOption(
            'desc',
            null,
            InputOption::VALUE_NONE,
            'Sort donors in descending order'
        );

        $adapter->addOption(
            'format',
            null,
            InputOption::VALUE_REQUIRED,
            sprintf(
                'Set output format, possible values: %s',
                implode(", ", $this->formatterCollection->getItemKeys())
            ),
            'list'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donors = [];

        $filter = new CombinedFilter(
            ...array_merge(
                array_map([$this->filterCollection, 'getFilter'], (array)$input->getOption('filter')),
                array_map([$this->filterCollection, 'getNegatedFilter'], (array)$input->getOption('filter-not'))
            )
        );

        foreach ($this->donorMapper->findAll() as $donor) {
            if ($filter->filterDonor($donor)) {
                $donors[] = $donor;
            }
        }

        /** @var string */
        $sorterId = $input->getOption('sorter');
        $sorter = $this->sorterCollection->getSorter($sorterId);

        if ($input->getOption('desc')) {
            $sorter = new DescendingSorter($sorter);
        }

        usort($donors, [$sorter, 'compareDonors']);

        /** @var string */
        $formatId = $input->getOption('format');
        $formatter = $this->formatterCollection->getFormatter($formatId);
        $formatter->initialize($output);

        foreach ($donors as $donor) {
            $formatter->formatDonor($donor);
        }

        $formatter->finalize();
    }
}
