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
 * Copyright 2016-21 Hannes Forsgård
 */

declare(strict_types=1);

namespace byrokrat\giroapp\Xml;

use byrokrat\giroapp\DependencyInjection;
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

/**
 * Create XmlMandate objects from xml source
 */
class XmlMandateParser
{
    use DependencyInjection\AccountFactoryProperty;
    use DependencyInjection\IdFactoryProperty;

    /** @var IdInterface */
    private $payeeOrgNr;

    /** @var AccountNumber */
    private $payeeBankgiro;

    public function __construct(IdInterface $payeeOrgNr, AccountNumber $payeeBankgiro)
    {
        $this->payeeOrgNr = $payeeOrgNr;
        $this->payeeBankgiro = $payeeBankgiro;
    }

    /**
     * @return array<XmlMandate>
     */
    public function parseXml(XmlObject $xmlRoot): array
    {
        /** @var array<XmlMandate> */
        $mandates = [];

        $stringValidator = new StringValidator();

        foreach ($xmlRoot->getElements('/DocumentElement/MedgivandeViaHemsida') as $xmlSource) {
            // Validate payee organisational number
            $orgNr = $xmlSource->readElement('/MedgivandeViaHemsida/Organisationsnr', new IdValidator());
            if ($this->payeeOrgNr->format('S-sk') != $orgNr) {
                // Hard failure, implicit rollback
                throw new InvalidDataException(sprintf(
                    'Invalid payee org nr %s, expecting %s',
                    $orgNr,
                    $this->payeeOrgNr->format('S-sk')
                ));
            }

            // Validate payee bankgiro account number
            $bankgiro = $xmlSource->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator());
            if (preg_replace('/\D/', '', $this->payeeBankgiro->getNumber()) != preg_replace('/\D/', '', $bankgiro)) {
                // Hard failure, implicit rollback
                throw new InvalidDataException(sprintf(
                    'Invalid payee bankgiro %s, expecting %s',
                    $bankgiro,
                    $this->payeeBankgiro->getNumber()
                ));
            }

            // require this empty element to exist
            $xmlSource->readElement('/MedgivandeViaHemsida/Autogiroanmälan_x002C__x0020_medgivande', $stringValidator);

            $mandate = new XmlMandate();

            $mandate->donorId = $this->idFactory->createId(
                $xmlSource->readElement('/MedgivandeViaHemsida/Kontoinnehavarens_x0020_personnr', new IdValidator())
            );

            if ($xmlSource->hasElement('/MedgivandeViaHemsida/Betalarnummer')) {
                try {
                    $mandate->payerNumber = $xmlSource->readElement(
                        '/MedgivandeViaHemsida/Betalarnummer',
                        new PayerNumberValidator()
                    );
                } catch (ValidatorException $e) {
                    // intentionally empty
                }
            }

            $mandate->account = $this->accountFactory->createAccount(
                $xmlSource->readElement('/MedgivandeViaHemsida/Kontonr', new AccountValidator())
            );

            $mandate->name = $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn', $stringValidator);

            $mandate->address = [
                'line1' =>
                    $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_1', $stringValidator),
                'line2' =>
                    $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_2', $stringValidator),
                'line3' =>
                    $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_3', $stringValidator),
                'postalCode' =>
                    $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_postnr', new PostalCodeValidator()),
                'postalCity' =>
                    $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_postort', $stringValidator)
            ];

            foreach ($xmlSource->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata') as $custom) {
                $mandate->attributes[$custom->readElement('/customdata/name', $stringValidator)]
                    = $custom->readElement('/customdata/value', $stringValidator);
            }

            $mandate->attributes['online_form_id']
                = $xmlSource->readElement('/MedgivandeViaHemsida/Formulärnamn', $stringValidator);

            $mandate->attributes['online_verification_time']
                = $xmlSource->readElement('/MedgivandeViaHemsida/Verifieringstid', $stringValidator);

            $mandate->attributes['online_verification_code']
                = $xmlSource->readElement('/MedgivandeViaHemsida/Verifieringsreferens', $stringValidator);

            $mandates[] = $mandate;
        }

        return $mandates;
    }
}
