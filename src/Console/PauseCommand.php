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
use byrokrat\giroapp\Events;
use byrokrat\giroapp\States;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\State\StatePool;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class PauseCommand implements CommandInterface
{
    use Helper\DonorArgument, DispatcherProperty;

    /**
     * @var StatePool
     */
    private $statePool;

    public function __construct(StatePool $statePool)
    {
        $this->statePool = $statePool;
    }

    public function configure(Adapter $adapter): void
    {
        $adapter->setName('pause');
        $adapter->setDescription('Pause a donor mandate');
        $adapter->setHelp('Pause a mandate and temporarily stop receiving donations from donor');
        $this->configureDonorArgument($adapter);
        $adapter->addOption('restart', null, InputOption::VALUE_NONE, 'Restart a previously paused donor');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->readDonor($input);

        if ($input->getOption('restart')) {
            if (!$donor->getState()->isPaused()) {
                throw new \RuntimeException('Unable to restart donor that is not paused.');
            }

            $donor->setState($this->statePool->getState(States::MANDATE_APPROVED));

            $this->dispatcher->dispatch(
                Events::MANDATE_RESTARTED,
                new DonorEvent("Restart requested for mandate <info>{$donor->getMandateKey()}</info>", $donor)
            );

            return;
        }

        if (!$donor->getState()->isActive()) {
            throw new \RuntimeException('Unable to pause non active donor.');
        }

        $donor->setState($this->statePool->getState(States::PAUSE_MANDATE));

        $this->dispatcher->dispatch(
            Events::MANDATE_PAUSE_REQUESTED,
            new DonorEvent("Pause requested for mandate <info>{$donor->getMandateKey()}</info>", $donor)
        );
    }
}
