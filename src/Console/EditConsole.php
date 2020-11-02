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

    private const OPTIONS = [
        self::OPTION_NAME,
        self::OPTION_ADDRESS1,
        self::OPTION_ADDRESS2,
        self::OPTION_ADDRESS3,
        self::OPTION_POSTAL_CODE,
        self::OPTION_POSTAL_CITY,
        self::OPTION_EMAIL,
        self::OPTION_PHONE,
        self::OPTION_COMMENT,
    ];

    public function configure(Command $command): void
    {
        $this->configureDonorArgument($command);
        $command->setName('edit');
        $command->setDescription('Edit an existing donor');
        $command->setHelp('Edit a donor in the database.');

        foreach (self::OPTIONS as $option) {
            $command->addOption($option, null, InputOption::VALUE_REQUIRED, self::OPTION_DESCS[$option]);
        }

        $command->addOption(
            self::OPTION_ATTR_KEY,
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            self::OPTION_DESCS[self::OPTION_ATTR_KEY]
        );

        $command->addOption(
            self::OPTION_ATTR_VALUE,
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            self::OPTION_DESCS[self::OPTION_ATTR_VALUE]
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $commandQueue = [];

        $donor = $this->readDonor($input);

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $commandQueue[] = new CommandBus\UpdateName(
            $donor,
            $inputReader->readOptionalInput(
                self::OPTION_NAME,
                $donor->getName(),
                new Validator\ValidatorCollection(
                    new Validator\StringValidator,
                    new Validator\NotEmptyValidator
                )
            )
        );

        $commandQueue[] = new CommandBus\UpdatePostalAddress(
            $donor,
            new PostalAddress(
                $inputReader->readOptionalInput(
                    self::OPTION_ADDRESS1,
                    $donor->getPostalAddress()->getLine1(),
                    new Validator\StringValidator
                ),
                $inputReader->readOptionalInput(
                    self::OPTION_ADDRESS2,
                    $donor->getPostalAddress()->getLine2(),
                    new Validator\StringValidator
                ),
                $inputReader->readOptionalInput(
                    self::OPTION_ADDRESS3,
                    $donor->getPostalAddress()->getLine3(),
                    new Validator\StringValidator
                ),
                $inputReader->readOptionalInput(
                    self::OPTION_POSTAL_CODE,
                    $donor->getPostalAddress()->getPostalCode(),
                    new Validator\PostalCodeValidator
                ),
                $inputReader->readOptionalInput(
                    self::OPTION_POSTAL_CITY,
                    $donor->getPostalAddress()->getPostalCity(),
                    new Validator\StringValidator
                )
            )
        );

        $commandQueue[] = new CommandBus\UpdateEmail(
            $donor,
            $inputReader->readOptionalInput(self::OPTION_EMAIL, $donor->getEmail(), new Validator\EmailValidator)
        );

        $commandQueue[] = new CommandBus\UpdatePhone(
            $donor,
            $inputReader->readOptionalInput(self::OPTION_PHONE, $donor->getPhone(), new Validator\PhoneValidator)
        );

        $commandQueue[] = new CommandBus\UpdateComment(
            $donor,
            $inputReader->readOptionalInput(self::OPTION_COMMENT, $donor->getComment(), new Validator\StringValidator)
        );

        foreach ($donor->getAttributes() as $attrKey => $attrValue) {
            $commandQueue[] = new CommandBus\UpdateAttribute(
                $donor,
                $attrKey,
                $inputReader->readOptionalInput("attribute.$attrKey", $attrValue, new Validator\StringValidator)
            );
        }

        /** @var array<string> */
        $attrKeys = $input->getOption(self::OPTION_ATTR_KEY);

        /** @var array<string> */
        $attrValues = $input->getOption(self::OPTION_ATTR_VALUE);

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
