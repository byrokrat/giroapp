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

use byrokrat\giroapp\CommandBus\ChangeDonorState;
use byrokrat\giroapp\CommandBus\ForceDonorState;
use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\Validator\ChoiceValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

final class EditStateConsole implements ConsoleInterface
{
    use CommandBusProperty, Helper\DonorArgument;

    /**
     * @var StateCollection
     */
    private $stateCollection;

    public function __construct(StateCollection $stateCollection)
    {
        $this->stateCollection = $stateCollection;
    }

    public function configure(Command $command): void
    {
        $command->setName('edit-state');
        $command->setDescription('Edit donor state');
        $command->setHelp('Edit donor state');
        $this->configureDonorArgument($command);
        $command->addOption(
            'new-state',
            null,
            InputOption::VALUE_REQUIRED,
            'New donor state identifier'
        );
        $command->addOption('force', 'f', InputOption::VALUE_NONE, 'Force new state');
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->readDonor($input);

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $validStates = array_change_key_case(
            (array)array_combine($this->stateCollection->getItemKeys(), $this->stateCollection->getItemKeys()),
            CASE_LOWER
        );

        $newStateId = $inputReader->readInput(
            'new-state',
            Helper\QuestionFactory::createChoiceQuestion(
                'New donor state identifier',
                $validStates,
                $donor->getState()->getStateId()
            ),
            new ChoiceValidator($validStates)
        );

        $command = $input->getOption('force')
            ? new ForceDonorState($donor, $newStateId)
            : new ChangeDonorState($donor, $newStateId);

        $this->commandBus->handle($command);
    }
}
