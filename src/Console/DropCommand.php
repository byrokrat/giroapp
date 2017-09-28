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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;

/**
 * Command to drop a mandate (remove from database)
 */
class DropCommand implements CommandInterface
{
    use Traits\DonorArgumentTrait;

    public function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('drop');
        $wrapper->setDescription('Drop a donor mandate');
        $wrapper->setHelp('Remove a mandate completely from the database');
        $wrapper->addOption('force', 'f', InputOption::VALUE_NONE, 'Force drop');
        $this->configureDonorArgument($wrapper);
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $donorMapper = $container->get('byrokrat\giroapp\Mapper\DonorMapper');

        $donor = $this->getDonorUsingArgument($input, $donorMapper);

        if ($donor->getState()->getId() != States::INACTIVE && !$input->getOption('force')) {
            throw new \RuntimeException('Unable to drop mandate that is not inactive. Use -f to override.');
        }

        $donorMapper->delete($donor);

        $container->get('event_dispatcher')->dispatch(
            Events::MANDATE_DROPPED_EVENT,
            new DonorEvent(
                sprintf(
                    'Dropped mandate <info>%s</info>',
                    $donor->getMandateKey()
                ),
                $donor
            )
        );
    }
}
