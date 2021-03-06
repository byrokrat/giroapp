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

namespace byrokrat\giroapp\CommandBus;

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Event;
use byrokrat\giroapp\Domain\State\ExportableStateInterface;
use byrokrat\giroapp\Filesystem\Sha256File;
use byrokrat\giroapp\Workflow\Transitions;
use byrokrat\autogiro\Writer\WriterInterface;

final class ExportHandler
{
    use DependencyInjection\CommandBusProperty;
    use DependencyInjection\DispatcherProperty;
    use DependencyInjection\DonorQueryProperty;

    public const DEFAULT_FILE_NAME = 'giroapp-export';

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
    public function handle(): string
    {
        $exported = false;

        foreach ($this->donorQuery->findAll() as $donor) {
            $state = $donor->getState();

            if ($state instanceof ExportableStateInterface) {
                $this->dispatcher->dispatch(
                    new Event\DebugEvent("Exporting mandate '{$donor->getMandateKey()}'")
                );

                $state->exportToAutogiro($donor, $this->autogiroWriter);

                $this->commandBus->handle(new UpdateState($donor, Transitions::EXPORT, 'Exported to BGC'));

                $exported = true;
            }
        }

        if (!$exported) {
            return '';
        }

        $content = $this->autogiroWriter->getContent();

        $this->dispatcher->dispatch(
            new Event\FileExported(new Sha256File(self::DEFAULT_FILE_NAME, $content))
        );

        return $content;
    }
}
