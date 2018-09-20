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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DonorMapperProperty;
use byrokrat\giroapp\Filter\FilterContainer;
use byrokrat\giroapp\Formatter\FormatterContainer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to list donors in database
 */
final class LsCommand implements CommandInterface
{
    use DonorMapperProperty;

    /**
     * @var FilterContainer
     */
    private $filterContainer;

    /**
     * @var FormatterContainer
     */
    private $formatterContainer;

    public function __construct(FilterContainer $filterContainer, FormatterContainer $formatterContainer)
    {
        $this->filterContainer = $filterContainer;
        $this->formatterContainer = $formatterContainer;
    }

    public function configure(CommandWrapper $wrapper): void
    {
        $wrapper->setName('ls');
        $wrapper->setDescription('List donors');
        $wrapper->setHelp('List donors in database');

        $wrapper->addOption(
            'filter',
            null,
            InputOption::VALUE_REQUIRED,
            'Set donor filter',
            ''
        );

        $wrapper->addOption(
            'format',
            null,
            InputOption::VALUE_REQUIRED,
            'Set output format',
            'table'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $filter = $this->filterContainer->getFilter(
            $input->getOption('filter')
        );

        $formatter = $this->formatterContainer->getFormatter(
            $input->getOption('format')
        );

        $formatter->setOutput($output);

        foreach ($this->donorMapper->findAll() as $donor) {
            if ($filter->filterDonor($donor)) {
                $formatter->addDonor($donor);
            }
        }

        $formatter->dump();
    }
}
