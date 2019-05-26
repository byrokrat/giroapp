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
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\MandateSources;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Model\Builder\DonorBuilder;
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
        DependencyInjection\DispatcherProperty,
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

    /**
     * @var DonorBuilder
     */
    private $donorBuilder;

    public function __construct(DonorBuilder $donorBuilder)
    {
        $this->donorBuilder = $donorBuilder;
    }

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

        $this->donorBuilder->reset();

        $sources = ['p' => MandateSources::MANDATE_SOURCE_PAPER, 'o' => MandateSources::MANDATE_SOURCE_ONLINE_FORM];

        $this->donorBuilder->setMandateSource(
            $inputReader->readInput(
                'source',
                Helper\QuestionFactory::createChoiceQuestion(
                    $descs['source'],
                    $sources,
                    MandateSources::MANDATE_SOURCE_PAPER
                ),
                new Validator\ChoiceValidator($sources)
            )
        );

        /** @var \byrokrat\id\IdInterface */
        $id = null;

        $inputReader->readInput(
            'id',
            Helper\QuestionFactory::createQuestion($descs['id']),
            new Validator\ValidatorCollection(
                new Validator\IdValidator,
                new Validator\CallbackValidator(function (string $value) use (&$id) {
                    $id = $this->idFactory->createId($value);
                })
            )
        );

        $this->donorBuilder->setId($id);

        $this->donorBuilder->setPayerNumber(
            $inputReader->readInput(
                'payer-number',
                Helper\QuestionFactory::createQuestion($descs['payer-number'], $id->format('Ssk')),
                new Validator\PayerNumberValidator
            )
        );

        /** @var \byrokrat\banking\AccountNumber */
        $account = null;

        $inputReader->readInput(
            'account',
            Helper\QuestionFactory::createQuestion($descs['account'])->setAutocompleterValues(
                ["3300,{$id->format('Ssk')}"]
            ),
            new Validator\ValidatorCollection(
                new Validator\AccountValidator,
                new Validator\CallbackValidator(function (string $value) use (&$account) {
                    $account = $this->accountFactory->createAccount($value);
                })
            )
        );

        $this->donorBuilder->setAccount($account);

        $this->donorBuilder->setName(
            $inputReader->readInput(
                'name',
                Helper\QuestionFactory::createQuestion($descs['name']),
                new Validator\ValidatorCollection(
                    new Validator\StringValidator,
                    new Validator\NotEmptyValidator
                )
            )
        );

        $this->donorBuilder->setDonationAmount(
            new SEK(
                $inputReader->readInput(
                    'amount',
                    Helper\QuestionFactory::createQuestion($descs['amount']),
                    new Validator\ValidatorCollection(
                        new Validator\NotEmptyValidator,
                        new Validator\NumericValidator
                    )
                )
            )
        );

        $this->donorBuilder->setPostalAddress(
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
        );

        $this->donorBuilder->setEmail(
            $inputReader->readInput(
                'email',
                Helper\QuestionFactory::createQuestion($descs['email'], ''),
                new Validator\EmailValidator
            )
        );

        $this->donorBuilder->setPhone(
            $inputReader->readInput(
                'phone',
                Helper\QuestionFactory::createQuestion($descs['phone'], ''),
                new Validator\PhoneValidator
            )
        );

        $this->donorBuilder->setComment(
            $inputReader->readInput(
                'comment',
                Helper\QuestionFactory::createQuestion($descs['comment'], ''),
                new Validator\StringValidator
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

            $attrValue = $inputReader->readInput(
                '',
                Helper\QuestionFactory::createQuestion('Value', $attrValues[$count] ?? ''),
                new Validator\StringValidator
            );

            $this->donorBuilder->setAttribute($attrKey, $attrValue);
        }

        $donor = $this->donorBuilder->buildDonor();

        $this->dispatcher->dispatch(
            Events::DONOR_ADDED,
            new DonorEvent(
                sprintf(
                    'Added donor <info>%s</info> with mandate key <info>%s</info>',
                    $donor->getName(),
                    $donor->getMandateKey()
                ),
                $donor
            )
        );
    }
}
