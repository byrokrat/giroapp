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

declare(strict_types = 1);

namespace byrokrat\giroapp\Xml;

use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\CommandBus\UpdateAttribute;
use byrokrat\giroapp\CommandBus\UpdateName;
use byrokrat\giroapp\CommandBus\UpdatePostalAddress;
use byrokrat\giroapp\DependencyInjection;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Exception\InvalidDataException;
use byrokrat\giroapp\Exception\ValidatorException;
use byrokrat\giroapp\Validator\AccountValidator;
use byrokrat\giroapp\Validator\IdValidator;
use byrokrat\giroapp\Validator\PayerNumberValidator;
use byrokrat\giroapp\Validator\PostalCodeValidator;
use byrokrat\giroapp\Validator\StringValidator;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use Money\Money;

class XmlMandateProcessor
{
    use DependencyInjection\AccountFactoryProperty,
        DependencyInjection\CommandBusProperty,
        DependencyInjection\DonorRepositoryProperty,
        DependencyInjection\IdFactoryProperty;

    /** @var IdInterface */
    private $payeeOrgNr;

    /** @var AccountNumber */
    private $payeeBankgiro;

    public function __construct(IdInterface $payeeOrgNr, AccountNumber $payeeBankgiro)
    {
        $this->payeeOrgNr = $payeeOrgNr;
        $this->payeeBankgiro = $payeeBankgiro;
    }

    public function process(XmlObject $xml): void
    {
        foreach ($xml->getElements('/DocumentElement/MedgivandeViaHemsida') as $mandate) {
            $orgNr = $mandate->readElement('/MedgivandeViaHemsida/Organisationsnr', new IdValidator);

            if ($this->payeeOrgNr->format('S-sk') != $orgNr) {
                throw new InvalidDataException(sprintf(
                    'Invalid payee org nr %s, expecting %s',
                    $orgNr,
                    $this->payeeOrgNr->format('S-sk')
                ));
            }

            $bankgiro = $mandate->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator);

            if (preg_replace('/\D/', '', $this->payeeBankgiro->getNumber()) != preg_replace('/\D/', '', $bankgiro)) {
                throw new InvalidDataException(sprintf(
                    'Invalid payee bankgiro %s, expecting %s',
                    $bankgiro,
                    $this->payeeBankgiro->getNumber()
                ));
            }

            $stringValidator = new StringValidator;

            // require this empty element to exist
            $mandate->readElement(
                '/MedgivandeViaHemsida/Autogiroanmälan_x002C__x0020_medgivande',
                $stringValidator
            );

            $donorId = $this->idFactory->createId(
                $mandate->readElement('/MedgivandeViaHemsida/Kontoinnehavarens_x0020_personnr', new IdValidator)
            );

            $payerNumber = $donorId->format('Ssk');

            if ($mandate->hasElement('/MedgivandeViaHemsida/Betalarnummer')) {
                try {
                    $payerNumber = $mandate->readElement(
                        '/MedgivandeViaHemsida/Betalarnummer',
                        new PayerNumberValidator
                    );
                } catch (ValidatorException $e) {
                    // intentionally empty
                }
            }

            $this->commandBus->handle(
                new AddDonor(
                    new NewDonor(
                        MandateSources::MANDATE_SOURCE_ONLINE_FORM,
                        $payerNumber,
                        $this->accountFactory->createAccount(
                            $mandate->readElement('/MedgivandeViaHemsida/Kontonr', new AccountValidator)
                        ),
                        $donorId,
                        Money::SEK('0')
                    )
                )
            );

            $donor = $this->donorRepository->requireByPayerNumber($payerNumber);

            $this->commandBus->handle(
                new UpdateName(
                    $donor,
                    $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn', $stringValidator)
                )
            );

            $this->commandBus->handle(
                new UpdatePostalAddress(
                    $donor,
                    new PostalAddress(
                        $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_1', $stringValidator),
                        $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_2', $stringValidator),
                        $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_3', $stringValidator),
                        $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postnr', new PostalCodeValidator),
                        $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postort', $stringValidator)
                    )
                )
            );

            foreach ($mandate->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata') as $custom) {
                $this->commandBus->handle(
                    new UpdateAttribute(
                        $donor,
                        $custom->readElement('/customdata/name', $stringValidator),
                        $custom->readElement('/customdata/value', $stringValidator)
                    )
                );
            }

            $this->commandBus->handle(
                new UpdateAttribute(
                    $donor,
                    'online_form_id',
                    $mandate->readElement('/MedgivandeViaHemsida/Formulärnamn', $stringValidator)
                )
            );

            $this->commandBus->handle(
                new UpdateAttribute(
                    $donor,
                    'online_verification_time',
                    $mandate->readElement('/MedgivandeViaHemsida/Verifieringstid', $stringValidator)
                )
            );

            $this->commandBus->handle(
                new UpdateAttribute(
                    $donor,
                    'online_verification_code',
                    $mandate->readElement('/MedgivandeViaHemsida/Verifieringsreferens', $stringValidator)
                )
            );
        }
    }
}
