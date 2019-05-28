<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Exception\InvalidDataException;
use byrokrat\giroapp\MandateSources;
use byrokrat\giroapp\Model\NewDonor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Validator\AccountValidator;
use byrokrat\giroapp\Validator\IdValidator;
use byrokrat\giroapp\Validator\PayerNumberValidator;
use byrokrat\giroapp\Validator\PostalCodeValidator;
use byrokrat\giroapp\Validator\StringValidator;
use byrokrat\amount\Currency\SEK;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use byrokrat\id\IdFactoryInterface;
use byrokrat\id\OrganizationId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlMandateParserSpec extends ObjectBehavior
{
    const PAYEE_ORG_NR = '111111-2222';
    const PAYEE_BANKGIRO = '123-123';

    function let(
        OrganizationId $payeeOrgNr,
        AccountNumber $payeeBankgiro,
        AccountFactoryInterface $accountFactory,
        IdFactoryInterface $idFactory,
        XmlObject $xmlRoot,
        XmlObject $xmlMandate
    ) {
        $this->beConstructedWith(
            $payeeOrgNr,
            $payeeBankgiro,
            $accountFactory,
            $idFactory
        );

        $payeeOrgNr->format('S-sk')->willReturn(self::PAYEE_ORG_NR);
        $payeeBankgiro->getNumber()->willReturn(self::PAYEE_BANKGIRO);

        $xmlRoot->getElements('/DocumentElement/MedgivandeViaHemsida')->willReturn([$xmlMandate]);

        $xmlMandate->readElement('/MedgivandeViaHemsida/Organisationsnr', new IdValidator)
            ->willReturn(self::PAYEE_ORG_NR);
        $xmlMandate->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator)
            ->willReturn(self::PAYEE_BANKGIRO);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(XmlMandateParser::CLASS);
    }

    function it_fails_on_invalid_payee_org_nr($xmlRoot, $xmlMandate)
    {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Organisationsnr', new IdValidator)
            ->willReturn('not-a-valid-org-nr');
        $this->shouldThrow(InvalidDataException::CLASS)->duringParse($xmlRoot);
    }

    function it_fails_on_invalid_payee_bankgiro($xmlRoot, $xmlMandate)
    {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator)
            ->willReturn('not-a-valid-bankgiro');
        $this->shouldThrow(InvalidDataException::CLASS)->duringParse($xmlRoot);
    }

    function it_creates_donors(
        $xmlRoot,
        $xmlMandate,
        $accountFactory,
        AccountNumber $account,
        $idFactory,
        IdInterface $donorId,
        XmlObject $xmlCustom
    ) {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Autogiroanmälan_x002C__x0020_medgivande', new StringValidator)
            ->willReturn('');

        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn', new StringValidator)->willReturn('name');

        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_1', new StringValidator)
            ->willReturn('1');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_2', new StringValidator)
            ->willReturn('2');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_3', new StringValidator)
            ->willReturn('3');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postnr', new PostalCodeValidator)
            ->willReturn('code');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postort', new StringValidator)
            ->willReturn('city');

        $donorId->format('Ssk')->willReturn('donor-id-payer-number');

        $xmlMandate->hasElement('/MedgivandeViaHemsida/Betalarnummer')->willReturn(true);
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalarnummer', new PayerNumberValidator)
            ->willReturn('payer-number');

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontonr', new AccountValidator)->willReturn('account');
        $accountFactory->createAccount('account')->willReturn($account);

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontoinnehavarens_x0020_personnr', new IdValidator)
            ->willReturn('id');
        $idFactory->createId('id')->willReturn($donorId);

        $xmlMandate->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata')->willReturn([$xmlCustom]);
        $xmlCustom->readElement('/customdata/name', new StringValidator)->willReturn('cust_name');
        $xmlCustom->readElement('/customdata/value', new StringValidator)->willReturn('cust_value');

        $xmlMandate->readElement('/MedgivandeViaHemsida/Formulärnamn', new StringValidator)->willReturn('form');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringstid', new StringValidator)->willReturn('time');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringsreferens', new StringValidator)->willReturn('code');

        $expectedDonor = new NewDonor(
            MandateSources::MANDATE_SOURCE_ONLINE_FORM,
            'payer-number',
            $account->getWrappedObject(),
            $donorId->getWrappedObject(),
            'name',
            new PostalAddress('1', '2', '3', 'code', 'city'),
            '',
            '',
            new SEK('0'),
            '',
            [
                'cust_name' => 'cust_value',
                'online_form_id' => 'form',
                'online_verification_time' => 'time',
                'online_verification_code' => 'code',
            ]
        );

        $this->parse($xmlRoot)->shouldIterateLike([$expectedDonor]);
    }
}
