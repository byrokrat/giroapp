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
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\Validator;
use byrokrat\amount\Currency\SEK;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

final class EditCommand implements CommandInterface
{
    use DependencyInjection\AccountFactoryProperty,
        DependencyInjection\DispatcherProperty,
        DependencyInjection\IdFactoryProperty,
        Helper\DonorArgument;

    /**
     * @var StateCollection
     */
    private $stateCollection;

    public function __construct(StateCollection $stateCollection)
    {
        $this->stateCollection = $stateCollection;
    }

    /**
     * Maps option names to free text descriptions
     */
    private const DESCRIPTIONS = [
        'name' => 'Donor name',
        'state' => 'Donor state identifier',
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

    public function configure(Adapter $adapter): void
    {
        $this->configureDonorArgument($adapter);
        $adapter->setName('edit');
        $adapter->setDescription('Edit an existing donor');
        $adapter->setHelp('Edit a donor in the database.');

        foreach (self::DESCRIPTIONS as $option => $desc) {
            $adapter->addOption($option, null, InputOption::VALUE_REQUIRED, $desc);
        }

        $adapter->addOption(
            'attr-key',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Attribute key'
        );

        $adapter->addOption(
            'attr-value',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Attribute value'
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $donor = $this->readDonor($input);

        $descs = self::DESCRIPTIONS;

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $this->dispatcher->dispatch(
            Events::INFO,
            new LogEvent("Editing mandate <info>{$donor->getMandateKey()}</info>")
        );

        $donor->setName(
            $inputReader->readInput(
                'name',
                Helper\QuestionFactory::createQuestion($descs['name'], $donor->getName()),
                new Validator\ValidatorCollection(
                    new Validator\StringValidator,
                    new Validator\NotEmptyValidator
                )
            )
        );

        $states = array_change_key_case(
            (array)array_combine($this->stateCollection->getItemKeys(), $this->stateCollection->getItemKeys()),
            CASE_LOWER
        );

        $donor->setState(
            $this->stateCollection->getState(
                $inputReader->readInput(
                    'state',
                    Helper\QuestionFactory::createChoiceQuestion(
                        $descs['state'],
                        $states,
                        $donor->getState()->getStateId()
                    ),
                    new Validator\ChoiceValidator($states)
                )
            ),
            'Donor edited by user'
        );

        $donor->setDonationAmount(
            new SEK(
                $inputReader->readInput(
                    'amount',
                    Helper\QuestionFactory::createQuestion($descs['amount'], $donor->getDonationAmount()->getAmount()),
                    new Validator\ValidatorCollection(
                        new Validator\NotEmptyValidator,
                        new Validator\NumericValidator
                    )
                )
            )
        );

        $donor->setPostalAddress(
            new PostalAddress(
                $inputReader->readInput(
                    'address1',
                    Helper\QuestionFactory::createQuestion($descs['address1'], $donor->getPostalAddress()->getLine1()),
                    new Validator\StringValidator
                ),
                $inputReader->readInput(
                    'address2',
                    Helper\QuestionFactory::createQuestion($descs['address2'], $donor->getPostalAddress()->getLine2()),
                    new Validator\StringValidator
                ),
                $inputReader->readInput(
                    'address3',
                    Helper\QuestionFactory::createQuestion($descs['address3'], $donor->getPostalAddress()->getLine3()),
                    new Validator\StringValidator
                ),
                $inputReader->readInput(
                    'postal-code',
                    Helper\QuestionFactory::createQuestion(
                        $descs['postal-code'],
                        $donor->getPostalAddress()->getPostalCode()
                    ),
                    new Validator\PostalCodeValidator
                ),
                $inputReader->readInput(
                    'postal-city',
                    Helper\QuestionFactory::createQuestion(
                        $descs['postal-city'],
                        $donor->getPostalAddress()->getPostalCity()
                    ),
                    new Validator\StringValidator
                )
            )
        );

        $donor->setEmail(
            $inputReader->readInput(
                'email',
                Helper\QuestionFactory::createQuestion($descs['email'], $donor->getEmail()),
                new Validator\EmailValidator
            )
        );

        $donor->setPhone(
            $inputReader->readInput(
                'phone',
                Helper\QuestionFactory::createQuestion($descs['phone'], $donor->getPhone()),
                new Validator\PhoneValidator
            )
        );

        $donor->setComment(
            $inputReader->readInput(
                'comment',
                Helper\QuestionFactory::createQuestion($descs['comment'], $donor->getComment()),
                new Validator\StringValidator
            )
        );

        foreach ($donor->getAttributes() as $attrKey => $attrValue) {
            $donor->setAttribute(
                $attrKey,
                $inputReader->readInput(
                    '',
                    Helper\QuestionFactory::createQuestion("Attribute <info>$attrKey</info>", $attrValue),
                    new Validator\StringValidator
                )
            );
        }

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

            $donor->setAttribute($attrKey, $attrValue);
        }

        $this->dispatcher->dispatch(
            Events::DONOR_UPDATED,
            new DonorEvent(
                "Updated mandate <info>{$donor->getMandateKey()}</info>",
                $donor
            )
        );
    }
}
