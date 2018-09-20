<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Xml\CustomdataTranslator;
use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Exception\InvalidXmlException;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Model\PostalAddress;
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
        CustomdataTranslator $translator,
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

        $xmlMandate->readElement('/MedgivandeViaHemsida/Organisationsnr')->willReturn(self::PAYEE_ORG_NR);
        $xmlMandate->readElement('/MedgivandeViaHemsida/Bankgironr')->willReturn(self::PAYEE_BANKGIRO);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(XmlMandateParser::CLASS);
    }

    function it_fails_on_invalid_payee_org_nr($xmlRoot, $xmlMandate)
    {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Organisationsnr')->willReturn('not-a-valid-org-nr');
        $this->shouldThrow(InvalidXmlException::CLASS)->duringParse($xmlRoot);
    }

    function it_fails_on_invalid_payee_bankgiro($xmlRoot, $xmlMandate)
    {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Bankgironr')->willReturn('not-a-valid-bankgiro');
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
        $xmlMandate->readElement('/MedgivandeViaHemsida/Autogiroanmälan_x002C__x0020_medgivande')->willReturn('');

        $builder->reset()->willReturn($builder)->shouldBeCalled();
        $builder->setMandateSource(Donor::MANDATE_SOURCE_ONLINE_FORM)->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn')->willReturn('name');
        $builder->setName('name')->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_1')->willReturn('1');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_2')->willReturn('2');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_adress_3')->willReturn('3');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postnr')->willReturn('code');
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_postort')->willReturn('city');
        $builder->setPostalAddress(new PostalAddress('1', '2', '3', 'code', 'city'))
            ->willReturn($builder)
            ->shouldBeCalled();

        $xmlMandate->hasElement('/MedgivandeViaHemsida/Betalarnummer')->willReturn(true);
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalarnummer')->willReturn('payer-number');
        $builder->setPayerNumber('payer-number')->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontonr')->willReturn('account');
        $accountFactory->createAccount('account')->willReturn($account);
        $builder->setAccount($account)->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontoinnehavarens_x0020_personnr')->willReturn('id');
        $idFactory->createId('id')->willReturn($id);
        $builder->setId($id)->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringstid')->willReturn('time');
        $builder->setAttribute('verification_time', 'time')->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringsreferens')->willReturn('code');
        $builder->setAttribute('verification_code', 'code')->willReturn($builder)->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Formulärnamn')->willReturn('form');
        $xmlMandate->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata')->willReturn([$xmlCustom]);
        $xmlCustom->readElement('/customdata/name')->willReturn('cust_name');
        $xmlCustom->readElement('/customdata/value')->willReturn('cust_value');
        $translator->writeValue($builder, 'form', 'cust_name', 'cust_value')->shouldBeCalled();

        $builder->buildDonor()->willReturn($donor)->shouldBeCalled();

        $this->parse($xmlRoot)->shouldIterateAs([$donor]);
    }
}
