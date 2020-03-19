<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlMandateProcessor;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\CommandBus\CommandBusInterface;
use byrokrat\giroapp\CommandBus\AddDonor;
use byrokrat\giroapp\CommandBus\UpdateAttribute;
use byrokrat\giroapp\CommandBus\UpdateName;
use byrokrat\giroapp\CommandBus\UpdatePostalAddress;
use byrokrat\giroapp\CommandBus\UpdateState;
use byrokrat\giroapp\Db\DonorRepositoryInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\MandateSources;
use byrokrat\giroapp\Domain\NewDonor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\NewMandate;
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
use Money\Money;
use PhpSpec\ObjectBehavior;

class XmlMandateProcessorSpec extends ObjectBehavior
{
    const PAYEE_ORG_NR = '111111-2222';
    const PAYEE_BANKGIRO = '123-123';

    function let(
        IdInterface $payeeOrgNr,
        AccountNumber $payeeBankgiro,
        AccountFactoryInterface $accountFactory,
        IdFactoryInterface $idFactory,
        CommandBusInterface $commandBus,
        DonorRepositoryInterface $donorRepository,
        XmlObject $xmlRoot,
        XmlObject $xmlMandate
    ) {
        $this->beConstructedWith($payeeOrgNr, $payeeBankgiro);

        $this->setAccountFactory($accountFactory);
        $this->setIdFactory($idFactory);
        $this->setCommandBus($commandBus);
        $this->setDonorRepository($donorRepository);

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
        $this->shouldHaveType(XmlMandateProcessor::class);
    }

    function it_fails_on_invalid_payee_org_nr($xmlRoot, $xmlMandate)
    {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Organisationsnr', new IdValidator)
            ->willReturn('not-a-valid-org-nr');
        $this->shouldThrow(InvalidDataException::class)->duringProcess($xmlRoot);
    }

    function it_fails_on_invalid_payee_bankgiro($xmlRoot, $xmlMandate)
    {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Bankgironr', new AccountValidator)
            ->willReturn('not-a-valid-bankgiro');
        $this->shouldThrow(InvalidDataException::class)->duringProcess($xmlRoot);
    }

    function it_creates_donors(
        $xmlRoot,
        $xmlMandate,
        $accountFactory,
        AccountNumber $account,
        $idFactory,
        IdInterface $donorId,
        XmlObject $xmlCustom,
        $donorRepository,
        Donor $donor,
        $commandBus
    ) {
        $xmlMandate->readElement('/MedgivandeViaHemsida/Autogiroanmälan_x002C__x0020_medgivande', new StringValidator)
            ->willReturn('');

        $donorId->format('Ssk')->willReturn('donor-id-payer-number');

        $xmlMandate->hasElement('/MedgivandeViaHemsida/Betalarnummer')->willReturn(true);
        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalarnummer', new PayerNumberValidator)
            ->willReturn('payer-number');

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontonr', new AccountValidator)->willReturn('account');
        $accountFactory->createAccount('account')->willReturn($account);

        $xmlMandate->readElement('/MedgivandeViaHemsida/Kontoinnehavarens_x0020_personnr', new IdValidator)
            ->willReturn('id');
        $idFactory->createId('id')->willReturn($donorId);

        $donorRepository->requireByPayerNumber('payer-number')->willReturn($donor);

        $commandBus->handle(new AddDonor(
            new NewDonor(
                MandateSources::MANDATE_SOURCE_ONLINE_FORM,
                'payer-number',
                $account->getWrappedObject(),
                $donorId->getWrappedObject(),
                Money::SEK('0')
            )
        ))->shouldBeCalled();

        $commandBus->handle(
            new UpdateState($donor->getWrappedObject(), NewMandate::getStateId(), 'Mandate added from xml')
        )->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Betalares_x0020_namn', new StringValidator)->willReturn('name');

        $commandBus->handle(new UpdateName($donor->getWrappedObject(), 'name'))->shouldBeCalled();

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

        $commandBus->handle(
            new UpdatePostalAddress(
                $donor->getWrappedObject(),
                new PostalAddress('1', '2', '3', 'code', 'city')
            )
        )->shouldBeCalled();

        $xmlMandate->getElements('/MedgivandeViaHemsida/Övrig_x0020_info/customdata')->willReturn([$xmlCustom]);
        $xmlCustom->readElement('/customdata/name', new StringValidator)->willReturn('cust_name');
        $xmlCustom->readElement('/customdata/value', new StringValidator)->willReturn('cust_value');

        $commandBus->handle(
            new UpdateAttribute($donor->getWrappedObject(), 'cust_name', 'cust_value')
        )->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Formulärnamn', new StringValidator)->willReturn('form');

        $commandBus->handle(
            new UpdateAttribute($donor->getWrappedObject(), 'online_form_id', 'form')
        )->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringstid', new StringValidator)->willReturn('time');

        $commandBus->handle(
            new UpdateAttribute($donor->getWrappedObject(), 'online_verification_time', 'time')
        )->shouldBeCalled();

        $xmlMandate->readElement('/MedgivandeViaHemsida/Verifieringsreferens', new StringValidator)->willReturn('code');

        $commandBus->handle(
            new UpdateAttribute($donor->getWrappedObject(), 'online_verification_code', 'code')
        )->shouldBeCalled();

        $this->process($xmlRoot);
    }
}
