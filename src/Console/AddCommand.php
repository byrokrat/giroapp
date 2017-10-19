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
 * Copyright 2016-17 Hannes Forsgård
 */

declare(strict_types = 1);

namespace byrokrat\giroapp\Console;

use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Command to add a new mandate
 */
class AddCommand implements CommandInterface
{
    use Traits\InputReaderTrait;

    /**
     * @var array Maps option names to free text descriptions
     */
    private static $descriptions = [
        'source' => 'Mandate source (defaults to paper)',
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
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var DonorBuilder
     */
    private $donorBuilder;

    public function __construct(EventDispatcher $dispatcher, DonorBuilder $donorBuilder)
    {
        $this->dispatcher = $dispatcher;
        $this->donorBuilder = $donorBuilder;
    }

    public static function configure(CommandWrapper $wrapper)
    {
        $wrapper->setName('add');
        $wrapper->setDescription('Add a new donor');
        $wrapper->setHelp('Register a new mandate in database');

        foreach (self::$descriptions as $option => $desc) {
            $wrapper->addOption($option, null, InputOption::VALUE_REQUIRED, $desc);
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $descs = self::$descriptions;

        $this->donorBuilder->reset();

        $sources = [Donor::MANDATE_SOURCE_PAPER, Donor::MANDATE_SOURCE_ONLINE_FORM];

        $this->donorBuilder->setMandateSource(
            $this->inputReader->readInput(
                'source',
                new ChoiceQuestion($descs['source'], $sources, 0),
                function ($val) use ($sources) {
                    if (isset($sources[$val])) {
                        return $sources[$val];
                    }

                    if (in_array($val, $sources)) {
                        return $val;
                    }

                    throw new \RuntimeException("Invalid mandate source $val");
                }
            )
        );

        $this->donorBuilder->setId(
            $id = $this->inputReader->readInput(
                'id',
                $this->questionFactory->createQuestion($descs['id']),
                $this->validators->getIdValidator()
            )
        );

        $this->donorBuilder->setPayerNumber(
            $this->inputReader->readInput(
                'payer-number',
                $this->questionFactory->createQuestion($descs['payer-number'], $id->format('Ssk')),
                $this->validators->getPayerNumberValidator()
            )
        );

        $this->donorBuilder->setAccount(
            $this->inputReader->readInput(
                'account',
                $this->questionFactory->createQuestion($descs['account'])->setAutocompleterValues(
                    ["3300,{$id->format('Ssk')}"]
                ),
                $this->validators->getAccountValidator()
            )
        );

        $this->donorBuilder->setName(
            $this->inputReader->readInput(
                'name',
                $this->questionFactory->createQuestion($descs['name']),
                $this->validators->getRequiredStringValidator('Name')
            )
        );

        $this->donorBuilder->setDonationAmount(
            $this->inputReader->readInput(
                'amount',
                $this->questionFactory->createQuestion($descs['amount']),
                $this->validators->getAmountValidator()
            )
        );

        $this->donorBuilder->setPostalAddress(
            new PostalAddress(
                $this->inputReader->readInput(
                    'address1',
                    $this->questionFactory->createQuestion($descs['address1'], ''),
                    $this->validators->getStringFilter()
                ),
                $this->inputReader->readInput(
                    'address2',
                    $this->questionFactory->createQuestion($descs['address2'], ''),
                    $this->validators->getStringFilter()
                ),
                $this->inputReader->readInput(
                    'address3',
                    $this->questionFactory->createQuestion($descs['address3'], ''),
                    $this->validators->getStringFilter()
                ),
                $this->inputReader->readInput(
                    'postal-code',
                    $this->questionFactory->createQuestion($descs['postal-code'], ''),
                    $this->validators->getPostalCodeValidator()
                ),
                $this->inputReader->readInput(
                    'postal-city',
                    $this->questionFactory->createQuestion($descs['postal-city'], '')->setAutocompleterValues(
                        $this->validators->getSuggestedCities()
                    ),
                    $this->validators->getStringFilter()
                )
            )
        );

        $this->donorBuilder->setEmail(
            $this->inputReader->readInput(
                'email',
                $this->questionFactory->createQuestion($descs['email'], ''),
                $this->validators->getEmailValidator()
            )
        );

        $this->donorBuilder->setPhone(
            $this->inputReader->readInput(
                'phone',
                $this->questionFactory->createQuestion($descs['phone'], ''),
                $this->validators->getPhoneValidator()
            )
        );

        $this->donorBuilder->setComment(
            $this->inputReader->readInput(
                'comment',
                $this->questionFactory->createQuestion($descs['comment'], ''),
                $this->validators->getStringFilter()
            )
        );

        $donor = $this->donorBuilder->buildDonor();

        $this->dispatcher->dispatch(
            Events::MANDATE_ADDED_EVENT,
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
