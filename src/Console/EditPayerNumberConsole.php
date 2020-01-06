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
use byrokrat\giroapp\CommandBus\UpdatePayerNumber;
use byrokrat\giroapp\Validator\PayerNumberValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

final class EditPayerNumberConsole implements ConsoleInterface
{
    use CommandBusProperty, Helper\DonorArgument;

    public function configure(Command $command): void
    {
        $this->configureDonorArgument($command);
        $command->setName('edit-payer-number');
        $command->setDescription('Update payer number');
        $command->setHelp('Update payer number for a donor.');
        $command->addOption(
            'new-payer-number',
            null,
            InputOption::VALUE_REQUIRED,
            'New payer number'
        );
        $command->addOption('message', 'm', InputOption::VALUE_REQUIRED, 'Message describing payer number change');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Please note that this feature is experimental.');
        $output->writeln('Make sure to backup your data before continuing.');

        $donor = $this->readDonor($input);

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $newPayerNumber = $inputReader->readInput(
            'new-payer-number',
            Helper\QuestionFactory::createQuestion(
                'New payer number',
                $donor->getPayerNumber()
            ),
            new PayerNumberValidator
        );

        /** @var string $msg */
        $msg = $input->getOption('message') ?: 'Payer number changed by user';

        $this->commandBus->handle(new UpdatePayerNumber($donor, $newPayerNumber, $msg));
    }
}
