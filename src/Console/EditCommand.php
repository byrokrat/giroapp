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

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\States;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * Command to edit an existing mandate
 */
final class EditCommand implements CommandInterface
{
    use Helper\DonorArgument, DispatcherProperty;

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
        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);
        $descs = self::DESCRIPTIONS;

        $this->dispatcher->dispatch(
            Events::INFO,
            new LogEvent("Editing mandate <info>{$donor->getMandateKey()}</info>")
        );

        $donor->setName(
            $inputReader->readInput(
                'name',
                Helper\QuestionFactory::createQuestion($descs['name'], $donor->getName()),
                $this->validators->getRequiredStringValidator('Name')
            )
        );

        $states = [
            'a'  => States::ACTIVE,
            'e'  => States::ERROR,
            'i'  => States::INACTIVE,
            'n'  => States::NEW_MANDATE,
            'd'  => States::NEW_DIGITAL_MANDATE,
            'ns' => States::MANDATE_SENT,
            'ap' => States::MANDATE_APPROVED,
            'r'  => States::REVOKE_MANDATE,
            'rs' => States::REVOCATION_SENT,
            'pr' => States::PAUSE_MANDATE,
            'ps' => States::PAUSE_SENT,
            'p'  => States::PAUSED,
        ];

        $donor->setState(
            $inputReader->readInput(
                'state',
                Helper\QuestionFactory::createChoiceQuestion(
                    $descs['state'],
                    $states,
                    $donor->getState()->getStateId()
                ),
                $this->validators->getStateValidator($states)
            ),
            'Donor edited by user'
        );

        $donor->setDonationAmount(
            $inputReader->readInput(
                'amount',
                Helper\QuestionFactory::createQuestion($descs['amount'], $donor->getDonationAmount()->getAmount()),
                $this->validators->getAmountValidator()
            )
        );

        $donor->setPostalAddress(
            new PostalAddress(
                $inputReader->readInput(
                    'address1',
                    Helper\QuestionFactory::createQuestion($descs['address1'], $donor->getPostalAddress()->getLine1()),
                    $this->validators->getStringFilter()
                ),
                $inputReader->readInput(
                    'address2',
                    Helper\QuestionFactory::createQuestion($descs['address2'], $donor->getPostalAddress()->getLine2()),
                    $this->validators->getStringFilter()
                ),
                $inputReader->readInput(
                    'address3',
                    Helper\QuestionFactory::createQuestion($descs['address3'], $donor->getPostalAddress()->getLine3()),
                    $this->validators->getStringFilter()
                ),
                $inputReader->readInput(
                    'postal-code',
                    Helper\QuestionFactory::createQuestion(
                        $descs['postal-code'],
                        $donor->getPostalAddress()->getPostalCode()
                    ),
                    $this->validators->getPostalCodeValidator()
                ),
                $inputReader->readInput(
                    'postal-city',
                    Helper\QuestionFactory::createQuestion(
                        $descs['postal-city'],
                        $donor->getPostalAddress()->getPostalCity()
                    ),
                    $this->validators->getStringFilter()
                )
            )
        );

        $donor->setEmail(
            $inputReader->readInput(
                'email',
                Helper\QuestionFactory::createQuestion($descs['email'], $donor->getEmail()),
                $this->validators->getEmailValidator()
            )
        );

        $donor->setPhone(
            $inputReader->readInput(
                'phone',
                Helper\QuestionFactory::createQuestion($descs['phone'], $donor->getPhone()),
                $this->validators->getPhoneValidator()
            )
        );

        $donor->setComment(
            $inputReader->readInput(
                'comment',
                Helper\QuestionFactory::createQuestion($descs['comment'], $donor->getComment()),
                $this->validators->getStringFilter()
            )
        );

        foreach ($donor->getAttributes() as $attrKey => $attrValue) {
            $donor->setAttribute(
                $attrKey,
                $inputReader->readInput(
                    '',
                    Helper\QuestionFactory::createQuestion("Attribute <info>$attrKey</info>", $attrValue),
                    $this->validators->getStringFilter()
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
                $this->validators->getStringFilter()
            );

            if (!$attrKey) {
                break;
            }

            $attrValue = $inputReader->readInput(
                '',
                Helper\QuestionFactory::createQuestion('Value', $attrValues[$count] ?? ''),
                $this->validators->getStringFilter()
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
