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

use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\CommandBus\UpdateDonationAmount;
use byrokrat\giroapp\Validator;
use Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

final class EditAmountConsole implements ConsoleInterface
{
    use DependencyInjection\CommandBusProperty,
        DependencyInjection\MoneyFormatterProperty,
        DependencyInjection\MoneyParserProperty,
        Helper\DonorArgument;

    public function configure(Command $command): void
    {
        $this->configureDonorArgument($command);
        $command->setName('edit-amount');
        $command->setDescription('Update donor donation amount');
        $command->setHelp('Update monthly donation amount for a donor.');
        $command->addOption(
            'new-amount',
            null,
            InputOption::VALUE_REQUIRED,
            'New monthly donation amount'
        );
        $command->addOption('message', 'm', InputOption::VALUE_REQUIRED, 'Message describing amount change');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->readDonor($input);

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $amount = $this->moneyParser->parse(
            $inputReader->readInput(
                'new-amount',
                Helper\QuestionFactory::createQuestion(
                    'New monthly donation amount',
                    $this->moneyFormatter->format($donor->getDonationAmount())
                ),
                new Validator\ValidatorCollection(
                    new Validator\NotEmptyValidator,
                    new Validator\NumericValidator
                )
            )
        );

        /** @var string $msg */
        $msg = $input->getOption('message') ?: 'Amount edited by user';

        $this->commandBus->handle(new UpdateDonationAmount($donor, $amount, $msg));
    }
}
