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
use byrokrat\giroapp\DependencyInjection\DonorMapperProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to update database schema
 */
final class MigrateCommand implements CommandInterface
{
    use DispatcherProperty, DonorMapperProperty;

    public function configure(Adapter $wrapper): void
    {
        $wrapper->setName('migrate');
        $wrapper->setDescription('Update database schema');
        $wrapper->setHelp('Ensure that the database schema is up to date by triggering a rewrite of all donors');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        foreach ($this->donorMapper->findAll() as $donor) {
            $this->dispatcher->dispatch(
                Events::DONOR_UPDATED,
                new DonorEvent(
                    "Updated mandate <info>{$donor->getMandateKey()}</info>",
                    $donor
                )
            );
        }
    }
}
