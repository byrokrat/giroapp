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

use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Builder\DonorBuilder;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Question\Question;
use byrokrat\giroapp\Events;
use byrokrat\banking\AccountFactory;
use byrokrat\id\IdFactory;
use byrokrat\amount\Currency\SEK;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Builder\MandateKeyBuilder;

/**
 * Command to edit an existing mandate
 */
class EditCommand implements CommandInterface
{
    use Traits\DonorArgumentTrait;

    /**
     * @var CommandWrapper
     */
    private static $wrapper;

    public static function configure(CommandWrapper $wrapper)
    {
        self::$wrapper = $wrapper;
        $wrapper->setName('edit');
        $wrapper->setDescription('Edit an existing donor');
        $wrapper->setHelp('Edit a donor in the database.');
        self::configureDonorArgument($wrapper);
        $wrapper->addOption('name', null, InputOption::VALUE_REQUIRED, 'Payer name');
        $wrapper->addOption('state', null, InputOption::VALUE_REQUIRED, 'Donor state identifier');
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

    public function execute(InputInterface $input, OutputInterface $output, ContainerInterface $container)
    {
        $donorBuilder = $container->get('byrokrat\giroapp\Builder\DonorBuilder');
        $donorMapper = $container->get('byrokrat\giroapp\Mapper\DonorMapper');
        $accountFactory = $container->get('byrokrat\banking\AccountFactory');
        $idFactory = $container->get('byrokrat\id\IdFactory');
        $mandateKeyBuilder = $container->get('byrokrat\giroapp\Builder\MandateKeyBuilder');

        $donor = self::getDonorUsingArgument($input, $donorMapper);

        $output->writeln('Hash Id key: ' . $donor->getMandateKey());
        $output->writeln('Personal Id: ' . $donor->getDonorId());
        $output->writeln('Account number: ' . $donor->getAccount());

        $this->setName(
            $this->getProperty('name', 'Donor name', $donor->getName(), $input, $output),
            $donor
        );

        $donor->setState(
            $container->get('byrokrat\giroapp\State\StateFactory')->createState(
                $this->getProperty('state', 'Donor state', $donor->getState()->getId(), $input, $output)
            )
        );

        $this->setPostalAddress(
            [
                'address1' => $this->getProperty(
                    'address1',
                    'Donor address line 1',
                    $donor->getPostalAddress()->getLine1(),
                    $input,
                    $output
                ),
                'address2' => $this->getProperty(
                    'address2',
                    'Donor address line 2',
                    $donor->getPostalAddress()->getLine2(),
                    $input,
                    $output
                ),
                'address3' => $this->getProperty(
                    'address3',
                    'Donor address line 3',
                    $donor->getPostalAddress()->getLine3(),
                    $input,
                    $output
                ),
                'postal_code' => $this->getProperty(
                    'postal-code',
                    'Donor postal code',
                    $donor->getPostalAddress()->getPostalCode(),
                    $input,
                    $output
                ),
                'postal_city' => $this-> getProperty(
                    'postal-city',
                    'Donor address city',
                    $donor->getPostalAddress()->getPostalCity(),
                    $input,
                    $output
                )
            ],
            $donor
        );
        $this->setEmail(
            $this->getProperty('email', 'Contact email address', $donor->getEmail(), $input, $output),
            $donor
        );
        $this->setPhone(
            $this->getProperty('phone', 'Contact phone number', $donor->getPhone(), $input, $output),
            $donor
        );
        $this->setDonationAmount(
            $this->getProperty(
                'amount',
                'Monthly donation amount',
                $donor->getDonationAmount()->getAmount(),
                $input,
                $output
            ),
            $donor
        );
        $this->setComment(
            $this->getProperty('comment', 'Comment', $donor->getComment(), $input, $output),
            $donor
        );

        $donorMapper->save($donor);

        $container->get('event_dispatcher')->dispatch(
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
                new Question("$desc [$default]: ", $default)
            );
        }
        return $value;
    }

    private function setName(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setName($value);
        } else {
            throw new \Exception('Donor needs a name');
        }
    }

    private function setPostalAddress(
        array $values,
        Donor $donor
    ) {
        if ($values) {
            $donor->setPostalAddress(new PostalAddress(
                $values['address1'],
                $values['address2'],
                $values['address3'],
                $values['postal_code'],
                $values['postal_city']
            ));
        }
    }

    private function setEmail(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setEmail($value);
        }
    }

    private function setPhone(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setPhone($value);
        }
    }

    private function setDonationAmount(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $newDonationAmount = new SEK($value);
            $donor->setDonationAmount($newDonationAmount);
        }
    }

    private function setComment(
        string $value,
        Donor $donor
    ) {
        if ($value) {
            $donor->setComment($value);
        }
    }
}
