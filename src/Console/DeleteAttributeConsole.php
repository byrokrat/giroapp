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
 * Copyright 2016-20 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;

final class DeleteAttributeConsole implements ConsoleInterface
{
    use CommandBusProperty, Helper\DonorArgument;

    public function configure(Command $command): void
    {
        $this->configureDonorArgument($command);
        $command->setName('delete-attribute');
        $command->setDescription('Delete attribute(s) from donor');
        $command->setHelp('Delete one or more attributes from an existing donor.');

        $command->addOption(
            'attr-key',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Attribute key'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $commandQueue = [];

        $donor = $this->readDonor($input);

        /** @var array<string> */
        $attrKeys = $input->getOption('attr-key');

        foreach ($attrKeys as $attrKey) {
            $commandQueue[] = new CommandBus\RemoveAttribute($donor, $attrKey);
        }

        $questionHelper = new QuestionHelper;

        foreach ($donor->getAttributes() as $attrKey => $attrValue) {
            $requestRemove = $questionHelper->ask(
                $input,
                $output,
                new ConfirmationQuestion("Remove attribute <comment>$attrKey</comment> [<info>y/N</info>]? ", false)
            );

            if ($requestRemove) {
                $commandQueue[] = new CommandBus\RemoveAttribute($donor, $attrKey);
            }
        }

        foreach ($commandQueue as $command) {
            $this->commandBus->handle($command);
        }
    }
}
