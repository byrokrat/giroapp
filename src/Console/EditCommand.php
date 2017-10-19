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

use byrokrat\giroapp\Console\Helper\InputReader;
use byrokrat\giroapp\Console\Helper\Validators;
use byrokrat\giroapp\Events;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Event\LogEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Command to edit an existing mandate
 */
class EditCommand implements CommandInterface
{
    use Traits\DonorArgumentTrait;

    /**
     * @var array Maps option names to free text descriptions
     */
    private static $descriptions = [
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

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var InputReader
     */
    private $inputReader;

    /**
     * @var Validators
     */
    private $validators;

    public function __construct(EventDispatcher $dispatcher, InputReader $inputReader, Validators $validators)
    {
        $this->dispatcher = $dispatcher;
        $this->inputReader = $inputReader;
        $this->validators = $validators;
    }

    public static function configure(CommandWrapper $wrapper)
    {
        self::configureDonorArgument($wrapper);
        $wrapper->setName('edit');
        $wrapper->setDescription('Edit an existing donor');
        $wrapper->setHelp('Edit a donor in the database.');

        foreach (self::$descriptions as $option => $desc) {
            $wrapper->addOption($option, null, InputOption::VALUE_REQUIRED, $desc);
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $descs = self::$descriptions;

        $donor = $this->getDonor($input);

        $this->dispatcher->dispatch(
            Events::INFO_EVENT,
            new LogEvent("Editing mandate <info>{$donor->getMandateKey()}</info>")
        );

        $donor->setName(
            $this->inputReader->readInput(
                'name',
                new Question("{$descs['name']} [{$donor->getName()}]: ", $donor->getName()),
                $this->validators->getRequiredStringValidator('Name')
            )
        );

        $donor->setState(
            $this->inputReader->readInput(
                'state',
                new Question("{$descs['state']} [{$donor->getState()->getId()}]: ", $donor->getState()->getId()),
                $this->validators->getStateValidator()
            )
        );

        $donor->setDonationAmount(
            $this->inputReader->readInput(
                'amount',
                new Question(
                    "{$descs['amount']} [{$donor->getDonationAmount()->getAmount()}]: ",
                    $donor->getDonationAmount()->getAmount()
                ),
                $this->validators->getAmountValidator()
            )
        );

        $donor->setPostalAddress(
            new PostalAddress(
                $this->inputReader->readInput(
                    'address1',
                    new Question(
                        "{$descs['address1']} [{$donor->getPostalAddress()->getLine1()}]: ",
                        $donor->getPostalAddress()->getLine1()
                    ),
                    $this->validators->getStringFilter()
                ),
                $this->inputReader->readInput(
                    'address2',
                    new Question(
                        "{$descs['address2']} [{$donor->getPostalAddress()->getLine2()}]: ",
                        $donor->getPostalAddress()->getLine2()
                    ),
                    $this->validators->getStringFilter()
                ),
                $this->inputReader->readInput(
                    'address3',
                    new Question(
                        "{$descs['address3']} [{$donor->getPostalAddress()->getLine3()}]: ",
                        $donor->getPostalAddress()->getLine3()
                    ),
                    $this->validators->getStringFilter()
                ),
                $this->inputReader->readInput(
                    'postal-code',
                    new Question(
                        "{$descs['postal-code']} [{$donor->getPostalAddress()->getPostalCode()}]: ",
                        $donor->getPostalAddress()->getPostalCode()
                    ),
                    $this->validators->getPostalCodeValidator()
                ),
                $this->inputReader->readInput(
                    'postal-city',
                    (
                        new Question(
                            "{$descs['postal-city']} [{$donor->getPostalAddress()->getPostalCity()}]: ",
                            $donor->getPostalAddress()->getPostalCity()
                        )
                    )->setAutocompleterValues($this->validators->getSuggestedCities()),
                    $this->validators->getStringFilter()
                )
            )
        );

        $donor->setEmail(
            $this->inputReader->readInput(
                'email',
                new Question("{$descs['email']} [{$donor->getEmail()}]: ", $donor->getEmail()),
                $this->validators->getEmailValidator()
            )
        );

        $donor->setPhone(
            $this->inputReader->readInput(
                'phone',
                new Question("{$descs['phone']} [{$donor->getPhone()}]: ", $donor->getPhone()),
                $this->validators->getPhoneValidator()
            )
        );

        $donor->setComment(
            $this->inputReader->readInput(
                'comment',
                new Question("{$descs['comment']} [{$donor->getComment()}]: ", $donor->getComment()),
                $this->validators->getStringFilter()
            )
        );

        $this->dispatcher->dispatch(
            Events::MANDATE_EDITED_EVENT,
            new DonorEvent(
                sprintf(
                    'Updated mandate <info>%s</info>',
                    $donor->getMandateKey()
                ),
                $donor
            )
        );
    }
}
