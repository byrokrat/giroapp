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
use byrokrat\giroapp\States;
use byrokrat\giroapp\Event\DonorEvent;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command to completely remove a donor
 */
final class RemoveCommand implements CommandInterface
{
    use Helper\DonorArgument, DispatcherProperty;

    public static function configure(CommandWrapper $wrapper): void
    {
        $wrapper->setName('remove');
        $wrapper->setDescription('Remove a donor');
        $wrapper->setHelp('Remove a donor completely from the database');
        $wrapper->addOption('force', 'f', InputOption::VALUE_NONE, 'Force remove');
        self::configureDonorArgument($wrapper);
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->getDonor();

        if ($donor->getState()->getStateId() != States::INACTIVE && !$this->input->getOption('force')) {
            throw new \RuntimeException('Unable to remove donor that is not inactive. Use -f to override.');
        }

        $this->dispatcher->dispatch(
            Events::DONOR_REMOVED,
            new DonorEvent(
                sprintf(
                    'Removed mandate <info>%s</info>',
                    $donor->getMandateKey()
                ),
                $donor
            )
        );
    }
}
