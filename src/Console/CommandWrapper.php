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
use byrokrat\giroapp\DI\ContainerFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Wrapper of giroapp console commands
 */
class CommandWrapper extends Command
{
    /**
     * @var CommandInterface
     */
    private $command;

    public function __construct(CommandInterface $command)
    {
        $this->command = $command;
        parent::__construct();
    }

    /**
     * Configure the path option
     */
    protected function configure()
    {
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'User directory path');
        $this->command->configure($this);
    }

    /**
     * Dispatch events and call wrapped command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = (new ContainerFactory)->createContainer(
            (string)$input->getOption('path'),
            (string)getenv('GIROAPP_PATH')
        );

        $container->get('event_dispatcher')->dispatch(Events::EXECUTION_START_EVENT);

        $this->command->execute($input, $output, $container);

        $container->get('event_dispatcher')->dispatch(Events::EXECUTION_END_EVENT);
    }
}
