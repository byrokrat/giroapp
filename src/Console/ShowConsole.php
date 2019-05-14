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

use byrokrat\giroapp\Formatter\FormatterCollection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Display information on individual donors
 */
final class ShowConsole implements ConsoleInterface
{
    use Helper\DonorArgument;

    /**
     * @var FormatterCollection
     */
    private $formatterCollection;

    public function __construct(FormatterCollection $formatterCollection)
    {
        $this->formatterCollection = $formatterCollection;
    }

    public function configure(Command $command): void
    {
        $command->setName('show');
        $command->setDescription('Display donor information');
        $command->setHelp('Display information on individual donors');

        $this->configureDonorArgument($command);

        $command->addOption(
            'format',
            null,
            InputOption::VALUE_REQUIRED,
            sprintf(
                'Set output format, possible values: %s',
                implode(", ", $this->formatterCollection->getItemKeys())
            ),
            'human'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        /** @var string */
        $formatId = $input->getOption('format');

        $formatter = $this->formatterCollection->getFormatter($formatId);

        $formatter->initialize($output);

        $formatter->formatDonor($this->readDonor($input));

        $formatter->finalize();
    }
}
