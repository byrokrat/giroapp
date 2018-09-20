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

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\State\RevokeMandateState;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to revoke a mandate
 */
final class RevokeCommand implements CommandInterface
{
    use Helper\DonorArgument, DispatcherProperty;

    public function configure(Adapter $wrapper): void
    {
        $wrapper->setName('revoke');
        $wrapper->setDescription('Revoke a donor mandate');
        $wrapper->setHelp('Revoke a mandate and stop receiving donations from donor');
        $this->configureDonorArgument($wrapper);
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->getDonor($input);

        $donor->setState(new RevokeMandateState);

        $this->dispatcher->dispatch(
            Events::MANDATE_REVOKED,
            new DonorEvent(
                sprintf(
                    'Revoked mandate <info>%s</info>',
                    $donor->getMandateKey()
                ),
                $donor
            )
        );
    }
}
