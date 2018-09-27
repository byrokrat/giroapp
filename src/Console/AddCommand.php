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
 * Copyright 2016-18 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\DependencyInjection\DispatcherProperty;
use byrokrat\giroapp\DependencyInjection\ValidatorsProperty;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Model\Builder\DonorBuilder;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * Command to add a new mandate
 */
final class AddCommand implements CommandInterface
{
    use DispatcherProperty, ValidatorsProperty;

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

    public function configure(Adapter $adapter): void
    {
        $adapter->setName('add');
        $adapter->setDescription('Add a new donor');
        $adapter->setHelp('Register a new mandate in database');

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
        $descs = self::DESCRIPTIONS;

        $inputReader = new Helper\InputReader($input, $output, new QuestionHelper);

        $this->donorBuilder->reset();

        $sources = ['p' => Donor::MANDATE_SOURCE_PAPER, 'o' => Donor::MANDATE_SOURCE_ONLINE_FORM];

        $this->donorBuilder->setMandateSource(
            $inputReader->readInput(
                'source',
                Helper\QuestionFactory::createChoiceQuestion($descs['source'], $sources, Donor::MANDATE_SOURCE_PAPER),
                $this->validators->getChoiceValidator($sources)
            )
        );

        $this->donorBuilder->setId(
            $id = $inputReader->readInput(
                'id',
                Helper\QuestionFactory::createQuestion($descs['id']),
                $this->validators->getIdValidator()
            )
        );

        $this->donorBuilder->setPayerNumber(
            $inputReader->readInput(
                'payer-number',
                Helper\QuestionFactory::createQuestion($descs['payer-number'], $id->format('Ssk')),
                $this->validators->getPayerNumberValidator()
            )
        );

        $this->donorBuilder->setAccount(
            $inputReader->readInput(
                'account',
                Helper\QuestionFactory::createQuestion($descs['account'])->setAutocompleterValues(
                    ["3300,{$id->format('Ssk')}"]
                ),
                $this->validators->getAccountValidator()
            )
        );

        $this->donorBuilder->setName(
            $inputReader->readInput(
                'name',
                Helper\QuestionFactory::createQuestion($descs['name']),
                $this->validators->getRequiredStringValidator('Name')
            )
        );

        $this->donorBuilder->setDonationAmount(
            $inputReader->readInput(
                'amount',
                Helper\QuestionFactory::createQuestion($descs['amount']),
                $this->validators->getAmountValidator()
            )
        );

        $this->donorBuilder->setPostalAddress(
            new PostalAddress(
                $inputReader->readInput(
                    'address1',
                    Helper\QuestionFactory::createQuestion($descs['address1'], ''),
                    $this->validators->getStringFilter()
                ),
                $inputReader->readInput(
                    'address2',
                    Helper\QuestionFactory::createQuestion($descs['address2'], ''),
                    $this->validators->getStringFilter()
                ),
                $inputReader->readInput(
                    'address3',
                    Helper\QuestionFactory::createQuestion($descs['address3'], ''),
                    $this->validators->getStringFilter()
                ),
                $inputReader->readInput(
                    'postal-code',
                    Helper\QuestionFactory::createQuestion($descs['postal-code'], ''),
                    $this->validators->getPostalCodeValidator()
                ),
                $inputReader->readInput(
                    'postal-city',
                    Helper\QuestionFactory::createQuestion($descs['postal-city'], '')->setAutocompleterValues(
                        $this->validators->getSuggestedCities()
                    ),
                    $this->validators->getStringFilter()
                )
            )
        );

        $this->donorBuilder->setEmail(
            $inputReader->readInput(
                'email',
                Helper\QuestionFactory::createQuestion($descs['email'], ''),
                $this->validators->getEmailValidator()
            )
        );

        $this->donorBuilder->setPhone(
            $inputReader->readInput(
                'phone',
                Helper\QuestionFactory::createQuestion($descs['phone'], ''),
                $this->validators->getPhoneValidator()
            )
        );

        $this->donorBuilder->setComment(
            $inputReader->readInput(
                'comment',
                Helper\QuestionFactory::createQuestion($descs['comment'], ''),
                $this->validators->getStringFilter()
            )
        );

        $attrKeys = $input->getOption('attr-key');
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
