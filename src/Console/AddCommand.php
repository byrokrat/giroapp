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

use byrokrat\giroapp\Events;
use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\amount\Currency\SEK;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Command to add a new mandate
 */
class AddCommand implements CommandInterface
{
    /**
     * @var CommandWrapper
     */
    private static $wrapper;

    /**
     * @var EventDispatcher
     */
    private $dispatcher;

    /**
     * @var DonorBuilder
     */
    private $donorBuilder;

    /**
     * @var AccountFactory
     */
    private $accountFactory;

    /**
     * @var IdFactory
     */
    private $idFactory;

    public function __construct(
        EventDispatcher $dispatcher,
        DonorBuilder $donorBuilder,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->dispatcher = $dispatcher;
        $this->donorBuilder = $donorBuilder;
        $this->accountFactory = $accountFactory;
        $this->idFactory = $idFactory;
    }

    public static function configure(CommandWrapper $wrapper)
    {
        self::$wrapper = $wrapper;
        $wrapper->setName('add');
        $wrapper->setDescription('Add a new donor');
        $wrapper->setHelp('Register a new traditional printed mandate in database');
        $wrapper->addOption('payer-number', null, InputOption::VALUE_REQUIRED, 'Unique payer identifier');
        $wrapper->addOption('account', null, InputOption::VALUE_REQUIRED, 'Payer account number');
        $wrapper->addOption('id', null, InputOption::VALUE_REQUIRED, 'Payer personal number or organisation number');
        $wrapper->addOption('name', null, InputOption::VALUE_REQUIRED, 'Payer name');
        $wrapper->addOption('address1', null, InputOption::VALUE_REQUIRED, 'Address field 1');
        $wrapper->addOption('address2', null, InputOption::VALUE_REQUIRED, 'Address field 2');
        $wrapper->addOption('address3', null, InputOption::VALUE_REQUIRED, 'Address field 3');
        $wrapper->addOption('postal-code', null, InputOption::VALUE_REQUIRED, 'Postal code');
        $wrapper->addOption('postal-city', null, InputOption::VALUE_REQUIRED, 'Postal city');
        $wrapper->addOption('email', null, InputOption::VALUE_REQUIRED, 'Contact email address');
        $wrapper->addOption('phone', null, InputOption::VALUE_REQUIRED, 'Contact phone number');
        $wrapper->addOption('amount', null, InputOption::VALUE_REQUIRED, 'Monthly donation amount');
        $wrapper->addOption('comment', null, InputOption::VALUE_REQUIRED, 'Comment');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->donorBuilder->reset();

        $this->donorBuilder->setMandateSource(Donor::MANDATE_SOURCE_PAPER);

        $this->setPayerNumber(
            $this->getProperty('payer-number', 'Unique ID number for donor', '', $input, $output)
        );

        $this->setAccount(
            $this->getProperty('account', 'Donor account number', '', $input, $output)
        );

        $this->setId(
            $this->getProperty('id', 'Donor personal id number or organisation number', '', $input, $output)
        );

        $this->setName(
            $this->getProperty('name', 'Donor name', '', $input, $output)
        );

        $this->setPostalAddress(
            [
                'address1' => $this->getProperty('address1', 'Donor address line 1', '', $input, $output),
                'address2' => $this->getProperty('address2', 'Donor address line 2', '', $input, $output),
                'address3' => $this->getProperty('address3', 'Donor address line 3', '', $input, $output),
                'postal_code' => $this->getProperty('postal-code', 'Donor postal code', '', $input, $output),
                'postal_city' => $this-> getProperty('postal-city', 'Donor address city', '', $input, $output),
            ]
        );

        $this->setEmail(
            $this->getProperty('email', 'Contact email address', '', $input, $output)
        );

        $this->setPhone(
            $this->getProperty('phone', 'Contact phone number', '', $input, $output)
        );

        $this->setDonationAmount(
            $this->getProperty('amount', 'Monthly donation amount', '0', $input, $output)
        );

        $this->setComment(
            $this->getProperty('comment', 'Comment', '', $input, $output)
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

    private function getProperty(
        string $key,
        string $desc,
        string $default,
        InputInterface $input,
        OutputInterface $output
    ): string {
        $value = $input->getOption($key);

        if (!$value) {
            $value = self::$wrapper->getHelper('question')->ask(
                $input,
                $output,
                new Question("$desc: ", $default)
            );
        }

        return $value;
    }

    private function setPayerNumber(string $value)
    {
        if (is_numeric($value) && strlen($value) <= 16) {
            $this->donorBuilder->setPayerNumber($value);
        } else {
            throw new \Exception('Payer number must be numerical, and max 16 digits');
        }
    }

    private function setAccount($value)
    {
        if ($value) {
            $this->donorBuilder->setAccount(
                $this->accountFactory->createAccount($value)
            );
        } else {
            throw new \Exception('Donor needs an account number');
        }
    }

    private function setId(string $value)
    {
        $this->donorBuilder->setId(
            $this->idFactory->create($value)
        );
    }

    private function setName(string $value)
    {
        if ($value) {
            $this->donorBuilder->setName($value);
        } else {
            throw new \Exception('Donor needs a name');
        }
    }

    private function setPostalAddress(array $values)
    {
        if ($values) {
            $this->donorBuilder->setPostalAddress(new PostalAddress(
                $values['address1'],
                $values['address2'],
                $values['address3'],
                $values['postal_code'],
                $values['postal_city']
            ));
        }
    }

    private function setEmail(string $value)
    {
        if ($value) {
            $this->donorBuilder->setEmail($value);
        }
    }

    private function setPhone(string $value)
    {
        if ($value) {
            $this->donorBuilder->setPhone($value);
        }
    }

    private function setDonationAmount(string $value)
    {
        if ($value) {
            $newDonationAmount = new SEK($value);
            $this->donorBuilder->setDonationAmount($newDonationAmount);
        }
    }

    private function setComment(string $value)
    {
        if ($value) {
            $this->donorBuilder->setComment($value);
        }
    }
}
