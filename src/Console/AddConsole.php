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

declare(strict_types=1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\CommandBus\UpdateAttribute;
use byrokrat\giroapp\CommandBus\UpdateComment;
use byrokrat\giroapp\CommandBus\UpdateEmail;
use byrokrat\giroapp\CommandBus\UpdateName;
use byrokrat\giroapp\CommandBus\UpdatePhone;
use byrokrat\giroapp\CommandBus\UpdatePostalAddress;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\NewMandate;
use byrokrat\giroapp\Validator;
use Money\Currency;
use Money\Money;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

final class AddConsole implements ConsoleInterface
{
    use DependencyInjection\AccountFactoryProperty;
    use DependencyInjection\CommandBusProperty;
    use DependencyInjection\DonorRepositoryProperty;
    use DependencyInjection\MoneyParserProperty;
    use DependencyInjection\IdFactoryProperty;
    use Helper\DryRun;

    private const OPTIONS = [
        self::OPTION_SOURCE,
        self::OPTION_ID,
        self::OPTION_PAYER_NUMBER,
        self::OPTION_ACCOUNT,
        self::OPTION_NAME,
        self::OPTION_AMOUNT,
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
        $command->setName('add');
        $command->setDescription('Add a new donor');
        $command->setHelp('Register a new mandate in database');

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

        $this->configureDryRun($command);
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper());

        $sources = ['p' => MandateSources::MANDATE_SOURCE_PAPER, 'o' => MandateSources::MANDATE_SOURCE_ONLINE_FORM];

        $mandateSource = $inputReader->readInput(
            self::OPTION_SOURCE,
            Helper\QuestionFactory::createChoiceQuestion(
                self::OPTION_DESCS[self::OPTION_SOURCE],
                $sources,
                MandateSources::MANDATE_SOURCE_ONLINE_FORM
            ),
            new Validator\ChoiceValidator($sources)
        );

        /** @var \byrokrat\id\IdInterface */
        $donorId = null;

        $inputReader->readInput(
            self::OPTION_ID,
            Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_ID]),
            new Validator\ValidatorCollection(
                new Validator\IdValidator(),
                new Validator\CallbackValidator(function (string $value) use (&$donorId) {
                    $donorId = $this->idFactory->createId($value);
                })
            )
        );

        $payerNumber = $inputReader->readInput(
            self::OPTION_PAYER_NUMBER,
            Helper\QuestionFactory::createQuestion(
                self::OPTION_DESCS[self::OPTION_PAYER_NUMBER],
                $donorId->format('Ssk')
            ),
            new Validator\PayerNumberValidator()
        );

        /** @var \byrokrat\banking\AccountNumber */
        $account = null;

        $inputReader->readInput(
            self::OPTION_ACCOUNT,
            Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_ACCOUNT])->setAutocompleterValues(
                ["3300,{$donorId->format('Ssk')}"]
            ),
            new Validator\ValidatorCollection(
                new Validator\AccountValidator(),
                new Validator\CallbackValidator(function (string $value) use (&$account) {
                    $account = $this->accountFactory->createAccount($value);
                })
            )
        );

        $donationAmount = $this->moneyParser->parse(
            $inputReader->readInput(
                self::OPTION_AMOUNT,
                Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_AMOUNT]),
                new Validator\ValidatorCollection(
                    new Validator\NotEmptyValidator(),
                    new Validator\NumericValidator()
                )
            ),
            new Currency('SEK')
        );

        $name = $inputReader->readInput(
            self::OPTION_NAME,
            Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_NAME]),
            new Validator\ValidatorCollection(
                new Validator\StringValidator(),
                new Validator\NotEmptyValidator()
            )
        );

        $postalAddress = new PostalAddress(
            $inputReader->readInput(
                self::OPTION_ADDRESS1,
                Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_ADDRESS1], ''),
                new Validator\StringValidator()
            ),
            $inputReader->readInput(
                self::OPTION_ADDRESS2,
                Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_ADDRESS2], ''),
                new Validator\StringValidator()
            ),
            $inputReader->readInput(
                self::OPTION_ADDRESS3,
                Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_ADDRESS3], ''),
                new Validator\StringValidator()
            ),
            $inputReader->readInput(
                self::OPTION_POSTAL_CODE,
                Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_POSTAL_CODE], ''),
                new Validator\PostalCodeValidator()
            ),
            $inputReader->readInput(
                self::OPTION_POSTAL_CITY,
                Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_POSTAL_CITY], ''),
                new Validator\StringValidator()
            )
        );

        $email = $inputReader->readInput(
            self::OPTION_EMAIL,
            Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_EMAIL], ''),
            new Validator\EmailValidator()
        );

        $phone = $inputReader->readInput(
            self::OPTION_PHONE,
            Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_PHONE], ''),
            new Validator\PhoneValidator()
        );

        $comment = $inputReader->readInput(
            self::OPTION_COMMENT,
            Helper\QuestionFactory::createQuestion(self::OPTION_DESCS[self::OPTION_COMMENT], ''),
            new Validator\StringValidator()
        );

        $attributes = [];

        /** @var array<string> */
        $attrKeys = $input->getOption(self::OPTION_ATTR_KEY);

        /** @var array<string> */
        $attrValues = $input->getOption(self::OPTION_ATTR_VALUE);

        for ($count = 0;; $count++) {
            $attrKey = $inputReader->readInput(
                '',
                Helper\QuestionFactory::createQuestion('Add an attribute (empty to skip)', $attrKeys[$count] ?? ''),
                new Validator\StringValidator()
            );

            if (!$attrKey) {
                break;
            }

            $attributes[$attrKey] = $inputReader->readInput(
                '',
                Helper\QuestionFactory::createQuestion('Value', $attrValues[$count] ?? ''),
                new Validator\StringValidator()
            );
        }

        $this->commandBus->handle(
            new AddDonor(new NewDonor($mandateSource, $payerNumber, $account, $donorId, $donationAmount))
        );

        $donor = $this->donorRepository->requireByPayerNumber($payerNumber);

        $this->commandBus->handle(new UpdateState($donor, NewMandate::getStateId(), 'Mandate added manually'));

        $this->commandBus->handle(new UpdateName($donor, $name));

        $this->commandBus->handle(new UpdatePostalAddress($donor, $postalAddress));

        $this->commandBus->handle(new UpdateEmail($donor, $email));

        $this->commandBus->handle(new UpdatePhone($donor, $phone));

        $this->commandBus->handle(new UpdateComment($donor, $comment));

        foreach ($attributes as $attrKey => $attrValue) {
            $this->commandBus->handle(new UpdateAttribute($donor, $attrKey, $attrValue));
        }

        $this->evaluateDryRun($input);
    }
}
