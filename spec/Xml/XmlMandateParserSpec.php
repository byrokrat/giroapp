<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Xml\XmlFormTranslator;
use byrokrat\giroapp\Model\Builder\DonorBuilder;
use byrokrat\giroapp\Exception\InvalidXmlException;
use byrokrat\giroapp\MandateSources;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Validator\AccountValidator;
use byrokrat\giroapp\Validator\IdValidator;
use byrokrat\giroapp\Validator\NumericValidator;
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
        DonorBuilder $builder,
        XmlFormTranslator $translator,
        AccountFactoryInterface $accountFactory,
        IdFactoryInterface $idFactory,
        XmlObject $xmlRoot,
        XmlObject $xmlMandate
    ) {
        $this->beConstructedWith(
            $payeeOrgNr,
            $payeeBankgiro,
            $builder,
            $translator,
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
        $this->shouldThrow(InvalidXmlException::CLASS)->duringParse($xmlRoot);
    }

    function it_fails_on_invalid_payee_bankgiro($xmlRoot, $xmlMandate)
    {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator)
            ->willReturn('not-a-valid-bankgiro');
        $this->shouldThrow(InvalidXmlException::CLASS)->duringParse($xmlRoot);
    }

    function it_creates_donors(
        $xmlRoot,
        $xmlMandate,
        $builder,
        $accountFactory,
        AccountNumber $account,
        $idFactory,
        IdInterface $id,
        XmlObject $xmlCustom,
        $translator,
        Donor $donor
    ) {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Autogiroanmälan_x002C__x0020_medgivande', new StringValidator)
            ->willReturn('');

        $builder->reset()->willReturn($builder)->shouldBeCalled();
        $builder->setMandateSource(MandateSources::MANDATE_SOURCE_ONLINE_FORM)->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn', new StringValidator)->willReturn('name');
        $builder->setName('name')->willReturn($builder)->shouldBeCalled();

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
        $builder->setPostalAddress(new PostalAddress('1', '2', '3', 'code', 'city'))
            ->willReturn($builder)
            ->shouldBeCalled();

        $xmlMandate->hasElement('/MedgivandeViaHemsida/Betalarnummer')->willReturn(true);
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalarnummer', new PayerNumberValidator)
            ->willReturn('payer-number');
        $builder->setPayerNumber('payer-number')->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontonr', new AccountValidator)->willReturn('account');
        $accountFactory->createAccount('account')->willReturn($account);
        $builder->setAccount($account)->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontoinnehavarens_x0020_personnr', new IdValidator)
            ->willReturn('id');
        $idFactory->createId('id')->willReturn($id);
        $builder->setId($id)->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringstid', new NumericValidator)->willReturn('time');
        $builder->setAttribute('verification_time', 'time')->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringsreferens', new StringValidator)->willReturn('code');
        $builder->setAttribute('verification_code', 'code')->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Formulärnamn', new StringValidator)->willReturn('form');
        $xmlMandate->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata')->willReturn([$xmlCustom]);
        $xmlCustom->readElement('/customdata/name', new StringValidator)->willReturn('cust_name');
        $xmlCustom->readElement('/customdata/value', new StringValidator)->willReturn('cust_value');
        $translator->writeValue($builder, 'form', 'cust_name', 'cust_value')->shouldBeCalled();

        $builder->buildDonor()->willReturn($donor)->shouldBeCalled();

        $this->parse($xmlRoot)->shouldIterateAs([$donor]);
    }
}
