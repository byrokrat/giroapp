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

namespace byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\CommandBus\ChangeDonorState;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\DependencyInjection\DonorQueryProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\ExportGenerated;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\State\ExportableStateInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use byrokrat\autogiro\Writer\WriterInterface;

final class ExportHandler extends DonorRepositoryAwareHandler
{
    use CommandBusProperty, DispatcherProperty, DonorQueryProperty;

    const DEFAULT_FILE_NAME = 'giroapp-export';

    /**
     * @var WriterInterface
     */
    private $autogiroWriter;

    public function __construct(WriterInterface $autogiroWriter)
    {
        $this->autogiroWriter = $autogiroWriter;
    }

    /**
     * @return string The generated autogiro file
     */
    public function handle(Export $command): string
    {
        $exported = false;

        foreach ($this->donorQuery->findAll() as $donor) {
            $state = $donor->getState();

            if ($state instanceof ExportableStateInterface) {
                $this->dispatcher->dispatch(
                    Events::DEBUG,
                    new LogEvent("Exporting mandate '{$donor->getMandateKey()}'")
                );

                $this->commandBus->handle(
                    new ChangeDonorState(
                        $donor,
                        $state->exportToAutogiro($donor, $this->autogiroWriter)
                    )
                );

                $exported = true;
            }
        }

        if (!$exported) {
            return '';
        }

        $content = $this->autogiroWriter->getContent();

        $this->dispatcher->dispatch(
            ExportGenerated::CLASS,
            new ExportGenerated(new Sha256File(self::DEFAULT_FILE_NAME, $content))
        );

        return $content;
    }
}
