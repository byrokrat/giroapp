<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlMandate;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Exception\InvalidDataException;
use byrokrat\giroapp\Validator\AccountValidator;
use byrokrat\giroapp\Validator\IdValidator;
use byrokrat\giroapp\Validator\PayerNumberValidator;
use byrokrat\giroapp\Validator\PostalCodeValidator;
use byrokrat\giroapp\Validator\StringValidator;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use byrokrat\id\IdFactoryInterface;
use PhpSpec\ObjectBehavior;

class XmlMandateParserSpec extends ObjectBehavior
{
    public const PAYEE_ORG_NR = '111111-2222';
    public const PAYEE_BANKGIRO = '123-123';

    function let(
        IdInterface $payeeOrgNr,
        AccountNumber $payeeBankgiro,
        AccountFactoryInterface $accountFactory,
        IdFactoryInterface $idFactory,
        XmlObject $xmlRoot,
        XmlObject $xmlSource
    ) {
        $this->beConstructedWith($payeeOrgNr, $payeeBankgiro);

        $this->setAccountFactory($accountFactory);
        $this->setIdFactory($idFactory);

        $payeeOrgNr->format('S-sk')->willReturn(self::PAYEE_ORG_NR);

        $payeeBankgiro->getNumber()->willReturn(self::PAYEE_BANKGIRO);

        $xmlRoot->getElements('/DocumentElement/MedgivandeViaHemsida')->willReturn([$xmlSource]);

        $xmlSource->readElement('/MedgivandeViaHemsida/Organisationsnr', new IdValidator())
            ->willReturn(self::PAYEE_ORG_NR);

        $xmlSource->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator())
            ->willReturn(self::PAYEE_BANKGIRO);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(XmlMandateParser::class);
    }

    function it_fails_on_invalid_payee_org_nr($xmlRoot, $xmlSource)
    {
        $xmlSource->readElement('/MedgivandeViaHemsida/Organisationsnr', new IdValidator())
            ->willReturn('not-a-valid-org-nr');

        $this->shouldThrow(InvalidDataException::class)->duringParseXml($xmlRoot);
    }

    function it_fails_on_invalid_payee_bankgiro($xmlRoot, $xmlSource)
    {
        $xmlSource->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator())
            ->willReturn('not-a-valid-bankgiro');

        $this->shouldThrow(InvalidDataException::class)->duringParseXml($xmlRoot);
    }

    function it_creates_value_objects(
        $xmlRoot,
        $xmlSource,
        $accountFactory,
        $idFactory,
        AccountNumber $account,
        IdInterface $donorId,
        XmlObject $xmlCustom
    ) {
        $expected = new XmlMandate();

        $xmlSource->readElement('/MedgivandeViaHemsida/Autogiroanmälan_x002C__x0020_medgivande', new StringValidator())
            ->willReturn('');

        $xmlSource->hasElement('/MedgivandeViaHemsida/Betalarnummer')->willReturn(true);
        $xmlSource->readElement('/MedgivandeViaHemsida/Betalarnummer', new PayerNumberValidator())
            ->willReturn('payer-number');
        $expected->payerNumber = 'payer-number';

        $xmlSource->readElement('/MedgivandeViaHemsida/Kontonr', new AccountValidator())->willReturn('account');
        $accountFactory->createAccount('account')->willReturn($account);
        $expected->account = $account->getWrappedObject();

        $xmlSource->readElement('/MedgivandeViaHemsida/Kontoinnehavarens_x0020_personnr', new IdValidator())
            ->willReturn('id');
        $idFactory->createId('id')->willReturn($donorId);
        $expected->donorId = $donorId->getWrappedObject();

        $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn', new StringValidator())
            ->willReturn('name');

        $expected->name = 'name';

        $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_1', new StringValidator())
            ->willReturn('1');
        $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_2', new StringValidator())
            ->willReturn('2');
        $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_3', new StringValidator())
            ->willReturn('3');
        $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_postnr', new PostalCodeValidator())
            ->willReturn('code');
        $xmlSource->readElement('/MedgivandeViaHemsida/Betalares_x0020_postort', new StringValidator())
            ->willReturn('city');
        $expected->address = [
            'line1' => '1',
            'line2' => '2',
            'line3' => '3',
            'postalCode' => 'code',
            'postalCity' => 'city',
        ];

        $xmlSource->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata')
            ->willReturn([$xmlCustom]);

        $xmlCustom->readElement('/customdata/name', new StringValidator())->willReturn('cust_name');
        $xmlCustom->readElement('/customdata/value', new StringValidator())->willReturn('cust_value');

        $expected->attributes['cust_name'] = 'cust_value';

        $xmlSource->readElement('/MedgivandeViaHemsida/Formulärnamn', new StringValidator())
            ->willReturn('form');

        $expected->attributes['online_form_id'] = 'form';

        $xmlSource->readElement('/MedgivandeViaHemsida/Verifieringstid', new StringValidator())
            ->willReturn('time');

        $expected->attributes['online_verification_time'] = 'time';

        $xmlSource->readElement('/MedgivandeViaHemsida/Verifieringsreferens', new StringValidator())
            ->willReturn('code');

        $expected->attributes['online_verification_code'] = 'code';

        $this->parseXml($xmlRoot)->shouldIterateLike([$expected]);
    }
}
