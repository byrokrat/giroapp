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
 * Copyright 2016-20 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DonorQueryProperty;
use byrokrat\giroapp\Filter\FilterCollection;
use byrokrat\giroapp\Filter\CombinedFilter;
use byrokrat\giroapp\Formatter\FormatterCollection;
use byrokrat\giroapp\Sorter\SorterCollection;
use byrokrat\giroapp\Sorter\DescendingSorter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ListConsole implements ConsoleInterface
{
    use DonorQueryProperty;

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

    public function configure(Command $command): void
    {
        $command->setName('list');
        $command->setAliases(['ls']);
        $command->setDescription('List donors');
        $command->setHelp('List donors in database');

        $command->addOption(
            'filter',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            sprintf(
                'Use donor filter, possible values: %s',
                implode(", ", $this->filterCollection->getItemKeys())
            )
        );

        $command->addOption(
            'filter-not',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            sprintf(
                'Use negated filter, possible values: %s',
                implode(", ", $this->filterCollection->getItemKeys())
            )
        );

        $command->addOption(
            'sorter',
            null,
            InputOption::VALUE_REQUIRED,
            sprintf(
                'Set donor sorter, possible values: %s',
                implode(", ", $this->sorterCollection->getItemKeys())
            ),
            ''
        );

        $command->addOption(
            'desc',
            null,
            InputOption::VALUE_NONE,
            'Sort donors in descending order'
        );

        $command->addOption(
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
        $filter = new CombinedFilter(
            ...array_merge(
                array_map([$this->filterCollection, 'getFilter'], (array)$input->getOption('filter')),
                array_map([$this->filterCollection, 'getNegatedFilter'], (array)$input->getOption('filter-not'))
            )
        );

        /** @var string */
        $sorterId = $input->getOption('sorter');
        $sorter = $this->sorterCollection->getSorter($sorterId);

        if ($input->getOption('desc')) {
            $sorter = new DescendingSorter($sorter);
        }

        /** @var string */
        $formatId = $input->getOption('format');
        $formatter = $this->formatterCollection->getFormatter($formatId);
        $formatter->initialize($output);

        foreach ($this->donorQuery->findAll()->filter($filter)->sort($sorter) as $donor) {
            $formatter->formatDonor($donor);
        }

        $formatter->finalize();
    }
}
