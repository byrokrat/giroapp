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

use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\CommandBus\UpdateAttribute;
use byrokrat\giroapp\CommandBus\UpdateComment;
use byrokrat\giroapp\CommandBus\UpdateEmail;
use byrokrat\giroapp\CommandBus\UpdateName;
use byrokrat\giroapp\CommandBus\UpdatePhone;
use byrokrat\giroapp\CommandBus\UpdatePostalAddress;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Validator;
use byrokrat\amount\Currency\SEK;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

final class AddConsole implements ConsoleInterface
{
    use DependencyInjection\AccountFactoryProperty,
        DependencyInjection\CommandBusProperty,
        DependencyInjection\DonorRepositoryProperty,
        DependencyInjection\IdFactoryProperty;

    /**
     * Maps option names to free text descriptions
     */
    private const DESCRIPTIONS = [
        'source' => 'Mandate source',
        'id' => 'Donor personal id',
        'payer-number' => 'Payer number',
        'account' => 'Donor account number',
        'name' => 'Donor name',
        'amount' => 'Monthly donation amount',
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
        $command->setName('add');
        $command->setDescription('Add a new donor');
        $command->setHelp('Register a new mandate in database');

        foreach (self::DESCRIPTIONS as $option => $desc) {
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
        $descs = self::DESCRIPTIONS;

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $sources = ['p' => MandateSources::MANDATE_SOURCE_PAPER, 'o' => MandateSources::MANDATE_SOURCE_ONLINE_FORM];

        $mandateSource = $inputReader->readInput(
            'source',
            Helper\QuestionFactory::createChoiceQuestion(
                $descs['source'],
                $sources,
                MandateSources::MANDATE_SOURCE_PAPER
            ),
            new Validator\ChoiceValidator($sources)
        );

        /** @var \byrokrat\id\IdInterface */
        $donorId = null;

        $inputReader->readInput(
            'id',
            Helper\QuestionFactory::createQuestion($descs['id']),
            new Validator\ValidatorCollection(
                new Validator\IdValidator,
                new Validator\CallbackValidator(function (string $value) use (&$donorId) {
                    $donorId = $this->idFactory->createId($value);
                })
            )
        );

        $payerNumber = $inputReader->readInput(
            'payer-number',
            Helper\QuestionFactory::createQuestion($descs['payer-number'], $donorId->format('Ssk')),
            new Validator\PayerNumberValidator
        );

        /** @var \byrokrat\banking\AccountNumber */
        $account = null;

        $inputReader->readInput(
            'account',
            Helper\QuestionFactory::createQuestion($descs['account'])->setAutocompleterValues(
                ["3300,{$donorId->format('Ssk')}"]
            ),
            new Validator\ValidatorCollection(
                new Validator\AccountValidator,
                new Validator\CallbackValidator(function (string $value) use (&$account) {
                    $account = $this->accountFactory->createAccount($value);
                })
            )
        );

        $donationAmount = new SEK(
            $inputReader->readInput(
                'amount',
                Helper\QuestionFactory::createQuestion($descs['amount']),
                new Validator\ValidatorCollection(
                    new Validator\NotEmptyValidator,
                    new Validator\NumericValidator
                )
            )
        );

        $this->commandBus->handle(
            new AddDonor(
                new NewDonor(
                    $mandateSource,
                    $payerNumber,
                    $account,
                    $donorId,
                    $donationAmount
                )
            )
        );

        $donor = $this->donorRepository->requireByPayerNumber($payerNumber);

        $this->commandBus->handle(
            new UpdateName(
                $donor,
                $inputReader->readInput(
                    'name',
                    Helper\QuestionFactory::createQuestion($descs['name']),
                    new Validator\ValidatorCollection(
                        new Validator\StringValidator,
                        new Validator\NotEmptyValidator
                    )
                )
            )
        );

        $this->commandBus->handle(
            new UpdatePostalAddress(
                $donor,
                new PostalAddress(
                    $inputReader->readInput(
                        'address1',
                        Helper\QuestionFactory::createQuestion($descs['address1'], ''),
                        new Validator\StringValidator
                    ),
                    $inputReader->readInput(
                        'address2',
                        Helper\QuestionFactory::createQuestion($descs['address2'], ''),
                        new Validator\StringValidator
                    ),
                    $inputReader->readInput(
                        'address3',
                        Helper\QuestionFactory::createQuestion($descs['address3'], ''),
                        new Validator\StringValidator
                    ),
                    $inputReader->readInput(
                        'postal-code',
                        Helper\QuestionFactory::createQuestion($descs['postal-code'], ''),
                        new Validator\PostalCodeValidator
                    ),
                    $inputReader->readInput(
                        'postal-city',
                        Helper\QuestionFactory::createQuestion($descs['postal-city'], ''),
                        new Validator\StringValidator
                    )
                )
            )
        );

        $this->commandBus->handle(
            new UpdateEmail(
                $donor,
                $inputReader->readInput(
                    'email',
                    Helper\QuestionFactory::createQuestion($descs['email'], ''),
                    new Validator\EmailValidator
                )
            )
        );

        $this->commandBus->handle(
            new UpdatePhone(
                $donor,
                $inputReader->readInput(
                    'phone',
                    Helper\QuestionFactory::createQuestion($descs['phone'], ''),
                    new Validator\PhoneValidator
                )
            )
        );

        $this->commandBus->handle(
            new UpdateComment(
                $donor,
                $inputReader->readInput(
                    'comment',
                    Helper\QuestionFactory::createQuestion($descs['comment'], ''),
                    new Validator\StringValidator
                )
            )
        );

        /** @var array */
        $attrKeys = $input->getOption('attr-key');

        /** @var array */
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

            $this->commandBus->handle(
                new UpdateAttribute(
                    $donor,
                    $attrKey,
                    $inputReader->readInput(
                        '',
                        Helper\QuestionFactory::createQuestion('Value', $attrValues[$count] ?? ''),
                        new Validator\StringValidator
                    )
                )
            );
        }
    }
}
