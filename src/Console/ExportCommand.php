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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\State\StatePool;
use byrokrat\autogiro\Writer\Writer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to create autogiro files
 */
class ExportCommand implements CommandInterface
{
    /**
     * @var DonorMapper
     */
    private $donorMapper;

    /**
     * @var Writer
     */
    private $autogiroWriter;

    /**
     * @var StatePool
     */
    private $statePool;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(
        DonorMapper $donorMapper,
        Writer $autogiroWriter,
        StatePool $statePool,
        EventDispatcher $dispatcher
    ) {
        $this->donorMapper = $donorMapper;
        $this->autogiroWriter = $autogiroWriter;
        $this->statePool = $statePool;
        $this->dispatcher = $dispatcher;
    }

    public static function configure(CommandWrapper $wrapper): void
    {
        $wrapper->setName('export');
        $wrapper->setDescription('Export a file to autogirot');
        $wrapper->setHelp('Create a file with new set of autogiro actions');
        $wrapper->discardOutputMessages();
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->donorMapper->findAll() as $donor) {
            if ($donor->getState()->isExportable()) {
                $donor->exportToAutogiro($this->autogiroWriter);
                $donor->setState($this->statePool->getState($donor->getState()->getNextStateId()));
                $this->dispatcher->dispatch(
                    Events::MANDATE_EDITED_EVENT,
                    new DonorEvent(
                        "Exported mandate <info>{$donor->getMandateKey()}</info>",
                        $donor
                    )
                );
            }
        }

        $output->write($this->autogiroWriter->getContent());
    }
}
