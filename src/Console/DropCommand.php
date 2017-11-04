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
use byrokrat\giroapp\States;
use byrokrat\giroapp\Event\DonorEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Command to drop a mandate (remove from database)
 */
class DropCommand implements CommandInterface
{
    use Traits\DonorArgumentTrait;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public static function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('drop');
        $wrapper->setDescription('Drop a donor mandate');
        $wrapper->setHelp('Remove a mandate completely from the database');
        $wrapper->addOption('force', 'f', InputOption::VALUE_NONE, 'Force drop');
        self::configureDonorArgument($wrapper);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $donor = $this->getDonor($input);

        if ($donor->getState()->getStateId() != States::INACTIVE && !$input->getOption('force')) {
            throw new \RuntimeException('Unable to drop mandate that is not inactive. Use -f to override.');
        }

        $this->dispatcher->dispatch(
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
