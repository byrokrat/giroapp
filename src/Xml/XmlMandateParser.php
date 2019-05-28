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

namespace byrokrat\giroapp\Xml;

use byrokrat\giroapp\Validator\AccountValidator;
use byrokrat\giroapp\Validator\IdValidator;
use byrokrat\giroapp\Validator\PayerNumberValidator;
use byrokrat\giroapp\Validator\PostalCodeValidator;
use byrokrat\giroapp\Validator\StringValidator;
use byrokrat\giroapp\MandateSources;
use byrokrat\giroapp\Model\NewDonor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Exception\InvalidDataException;
use byrokrat\giroapp\Exception\ValidatorException;
use byrokrat\amount\Currency\SEK;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdFactoryInterface;
use byrokrat\id\OrganizationId;

/**
 * Parse xml representations of online form mandates
 */
class XmlMandateParser
{
    /**
     * @var OrganizationId
     */
    private $payeeOrgNr;

    /**
     * @var AccountNumber
     */
    private $payeeBankgiro;

    /**
     * @var AccountFactoryInterface
     */
    private $accountFactory;

    /**
     * @var IdFactoryInterface
     */
    private $idFactory;

    public function __construct(
        OrganizationId $payeeOrgNr,
        AccountNumber $payeeBankgiro,
        AccountFactoryInterface $accountFactory,
        IdFactoryInterface $idFactory
    ) {
        $this->payeeOrgNr = $payeeOrgNr;
        $this->payeeBankgiro = $payeeBankgiro;
        $this->accountFactory = $accountFactory;
        $this->idFactory = $idFactory;
    }

    /**
     * Get generator that yields parsed Donor instances
     */
    public function parse(XmlObject $xml): iterable
    {
        $donors = [];

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

            $attributes = [];

            foreach ($mandate->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata') as $custom) {
                $attributes[$custom->readElement('/customdata/name', $stringValidator)]
                    = $custom->readElement('/customdata/value', $stringValidator);
            }

            $attributes['online_form_id']
                = $mandate->readElement('/MedgivandeViaHemsida/Formulärnamn', $stringValidator);

            $attributes['online_verification_time']
                = $mandate->readElement('/MedgivandeViaHemsida/Verifieringstid', $stringValidator);

            $attributes['online_verification_code']
                = $mandate->readElement('/MedgivandeViaHemsida/Verifieringsreferens', $stringValidator);

            $donors[] = new NewDonor(
                MandateSources::MANDATE_SOURCE_ONLINE_FORM,
                $payerNumber,
                $this->accountFactory->createAccount(
                    $mandate->readElement('/MedgivandeViaHemsida/Kontonr', new AccountValidator)
                ),
                $donorId,
                $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn', $stringValidator),
                new PostalAddress(
                    $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_1', $stringValidator),
                    $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_2', $stringValidator),
                    $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_3', $stringValidator),
                    $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postnr', new PostalCodeValidator),
                    $mandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postort', $stringValidator)
                ),
                '',
                '',
                new SEK('0'),
                '',
                $attributes
            );
        }

        return $donors;
    }
}
