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
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\DonorState\RevokeMandateState;
use byrokrat\giroapp\Mapper\DonorMapper;

/**
 * Command to revoke a mandate
 */
class RevokeCommand implements CommandInterface
{
    use Traits\DonorArgumentTrait;

    public function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('revoke');
        $wrapper->setDescription('Revoke a donor mandate');
        $wrapper->setHelp('Revoke a mandate and stop receiving donations from donor');
        $this->configureDonorArgument($wrapper);
    }

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $donorMapper = $container->get(DonorMapper::CLASS);

        $donor = $this->getDonorUsingArgument($input, $donorMapper);

        $donor->setState(new RevokeMandateState);

        $donorMapper->save($donor);

        $container->get('event_dispatcher')->dispatch(
            Events::MANDATE_REVOKED_EVENT,
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
