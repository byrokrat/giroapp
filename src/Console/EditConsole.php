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

use byrokrat\giroapp\DependencyInjection\CommandBusProperty;
use byrokrat\giroapp\CommandBus;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

final class EditConsole implements ConsoleInterface
{
    use CommandBusProperty, Helper\DonorArgument;

    /**
     * Maps option names to free text descriptions
     */
    private const DESCS = [
        'name' => 'Donor name',
        'address1' => 'Donor address line 1',
        'address2' => 'Donor address line 2',
        'address3' => 'Donor address line 3',
        'postal-code' => 'Donor postal code',
        'postal-city' => 'Donor postal city',
        'email' => 'Donor contact email address',
        'phone' => 'Donor contact phone number',
        'comment' => 'Comment'
    ];

    public function configure(Command $command): void
    {
        $this->configureDonorArgument($command);
        $command->setName('edit');
        $command->setDescription('Edit an existing donor');
        $command->setHelp('Edit a donor in the database.');

        foreach (self::DESCS as $option => $desc) {
            $command->addOption($option, null, InputOption::VALUE_REQUIRED, $desc);
        }

        $command->addOption(
            'attr-key',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Attribute key'
        );

        $command->addOption(
            'attr-value',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Attribute value'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $commandQueue = [];

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $donor = $this->readDonor($input);

        $commandQueue[] = new CommandBus\UpdateName(
            $donor,
            $inputReader->readInput(
                'name',
                Helper\QuestionFactory::createQuestion(self::DESCS['name'], $donor->getName()),
                new Validator\ValidatorCollection(
                    new Validator\StringValidator,
                    new Validator\NotEmptyValidator
                )
            )
        );

        $commandQueue[] = new CommandBus\UpdatePostalAddress(
            $donor,
            new PostalAddress(
                $inputReader->readInput(
                    'address1',
                    Helper\QuestionFactory::createQuestion(
                        self::DESCS['address1'],
                        $donor->getPostalAddress()->getLine1()
                    ),
                    new Validator\StringValidator
                ),
                $inputReader->readInput(
                    'address2',
                    Helper\QuestionFactory::createQuestion(
                        self::DESCS['address2'],
                        $donor->getPostalAddress()->getLine2()
                    ),
                    new Validator\StringValidator
                ),
                $inputReader->readInput(
                    'address3',
                    Helper\QuestionFactory::createQuestion(
                        self::DESCS['address3'],
                        $donor->getPostalAddress()->getLine3()
                    ),
                    new Validator\StringValidator
                ),
                $inputReader->readInput(
                    'postal-code',
                    Helper\QuestionFactory::createQuestion(
                        self::DESCS['postal-code'],
                        $donor->getPostalAddress()->getPostalCode()
                    ),
                    new Validator\PostalCodeValidator
                ),
                $inputReader->readInput(
                    'postal-city',
                    Helper\QuestionFactory::createQuestion(
                        self::DESCS['postal-city'],
                        $donor->getPostalAddress()->getPostalCity()
                    ),
                    new Validator\StringValidator
                )
            )
        );

        $commandQueue[] = new CommandBus\UpdateEmail(
            $donor,
            $inputReader->readInput(
                'email',
                Helper\QuestionFactory::createQuestion(self::DESCS['email'], $donor->getEmail()),
                new Validator\EmailValidator
            )
        );

        $commandQueue[] = new CommandBus\UpdatePhone(
            $donor,
            $inputReader->readInput(
                'phone',
                Helper\QuestionFactory::createQuestion(self::DESCS['phone'], $donor->getPhone()),
                new Validator\PhoneValidator
            )
        );

        $commandQueue[] = new CommandBus\UpdateComment(
            $donor,
            $inputReader->readInput(
                'comment',
                Helper\QuestionFactory::createQuestion(self::DESCS['comment'], $donor->getComment()),
                new Validator\StringValidator
            )
        );

        foreach ($donor->getAttributes() as $attrKey => $attrValue) {
            $commandQueue[] = new CommandBus\UpdateAttribute(
                $donor,
                $attrKey,
                $inputReader->readInput(
                    '',
                    Helper\QuestionFactory::createQuestion("Attribute <info>$attrKey</info>", $attrValue),
                    new Validator\StringValidator
                )
            );
        }

        /** @var array<string> */
        $attrKeys = $input->getOption('attr-key');

        /** @var array<string> */
        $attrValues = $input->getOption('attr-value');

        for ($count = 0;; $count++) {
            $attrKey = $inputReader->readInput(
                '',
                Helper\QuestionFactory::createQuestion('Add an attribute (empty to skip)', $attrKeys[$count] ?? ''),
                new Validator\StringValidator
            );

            if (!$attrKey) {
                break;
            }

            $commandQueue[] = new CommandBus\UpdateAttribute(
                $donor,
                $attrKey,
                $inputReader->readInput(
                    '',
                    Helper\QuestionFactory::createQuestion('Value', $attrValues[$count] ?? ''),
                    new Validator\StringValidator
                )
            );
        }

        foreach ($commandQueue as $command) {
            $this->commandBus->handle($command);
        }
    }
}
