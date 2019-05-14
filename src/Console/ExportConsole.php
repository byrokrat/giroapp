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

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\DependencyInjection\DonorQueryProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\FileEvent;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\Filesystem\Sha256File;
use byrokrat\autogiro\Writer\WriterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create autogiro files
 */
final class ExportConsole implements ConsoleInterface
{
    use DispatcherProperty, DonorQueryProperty;

    /**
     * @var WriterInterface
     */
    private $autogiroWriter;

    /**
     * @var StateCollection
     */
    private $stateCollection;

    public function __construct(WriterInterface $autogiroWriter, StateCollection $stateCollection)
    {
        $this->autogiroWriter = $autogiroWriter;
        $this->stateCollection = $stateCollection;
    }

    public function configure(Command $command): void
    {
        $command->setName('export');
        $command->setDescription('Export a file to autogirot');
        $command->setHelp('Create a file with new set of autogiro instructions');
        $command->addOption(
            'filename',
            null,
            InputOption::VALUE_REQUIRED,
            'Name of exported file',
            'giroapp-export.txt'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $exported = false;

        foreach ($this->donorQuery->findAll() as $donor) {
            if ($donor->getState()->isExportable()) {
                $donor->exportToAutogiro($this->autogiroWriter);
                $donor->setState($this->stateCollection->getState($donor->getState()->getNextStateId()));
                $this->dispatcher->dispatch(
                    Events::DONOR_UPDATED,
                    new DonorEvent("Exported mandate <info>{$donor->getMandateKey()}</info>", $donor)
                );
                $exported = true;
            }
        }

        /** @var string */
        $filename = $input->getOption('filename');

        if ($exported) {
            $this->dispatcher->dispatch(
                Events::FILE_EXPORTED,
                new FileEvent(
                    'Generating file to export',
                    new Sha256File($filename, $this->autogiroWriter->getContent())
                )
            );
        }
    }
}
