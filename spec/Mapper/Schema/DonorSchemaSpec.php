<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Mapper\Schema\PostalAddressSchema;
use byrokrat\giroapp\Model\DonorState\DonorStateFactory;
use byrokrat\giroapp\Model\DonorState\DonorState;
use byrokrat\giroapp\Model\DonorState\ActiveState;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Model\Donor;
use byrokrat\banking\AccountFactory;
use byrokrat\banking\AccountNumber;
use byrokrat\amount\Currency\SEK;
use byrokrat\id\IdFactory;
use byrokrat\id\PersonalId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorSchemaSpec extends ObjectBehavior
{
    function let(
        PostalAddressSchema $postalAddressSchema,
        DonorStateFactory $donorStateFactory,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->beConstructedWith(
            $postalAddressSchema,
            $donorStateFactory,
            $accountFactory,
            $idFactory
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorSchema::CLASS);
    }

    function it_can_create_donor(
        $postalAddressSchema,
        $donorStateFactory,
        $accountFactory,
        $idFactory,
        DonorState $donorState,
        AccountNumber $account,
        PersonalId $id,
        PostalAddress $address
    ) {
        $doc = [
            'mandateKey' => 'mandate-key',
            'state' => 'state',
            'mandateSource' => 'mandate-source',
            'payerNumber' => 'payer-number',
            'account' => 'account',
            'id' => 'id',
            'name' => 'name',
            'address' => ['foobar'],
            'email' => 'email',
            'phone' => 'phone',
            'donationAmount' => '1',
            'comment' => 'comment'
        ];

        $postalAddressSchema->fromArray(['foobar'])->willReturn($address);
        $donorStateFactory->createDonorState('state')->willReturn($donorState);
        $accountFactory->createAccount('account')->willReturn($account);
        $idFactory->create('id')->willReturn($id);

        $this->fromArray($doc)->shouldBeLike(
            new Donor(
                'mandate-key',
                $donorState->getWrappedObject(),
                'mandate-source',
                'payer-number',
                $account->getWrappedObject(),
                $id->getWrappedObject(),
                'name',
                $address->getWrappedObject(),
                'email',
                'phone',
                new SEK('1'),
                'comment'
            )
        );
    }

    function it_can_create_array(
        $postalAddressSchema,
        AccountNumber $account,
        PersonalId $id,
        PostalAddress $address,
        DonorState $donorState,
        SEK $amount
    ) {
        $postalAddressSchema->toArray($address)->willReturn(['foobar']);
        $donorState->getId()->willReturn('ActiveState');
        $account->getNumber()->willReturn('account');
        $id->format('S-sk')->willReturn('id');
        $amount->getAmount()->willReturn('1');

        $donor = new Donor(
            'mandate-key',
            $donorState->getWrappedObject(),
            'mandate-source',
            'payer-number',
            $account->getWrappedObject(),
            $id->getWrappedObject(),
            'name',
            $address->getWrappedObject(),
            'email',
            'phone',
            $amount->getWrappedObject(),
            'comment'
        );

        $this->toArray($donor)->shouldBeLike([
            'mandateKey' => 'mandate-key',
            'state' => 'ActiveState',
            'mandateSource' => 'mandate-source',
            'payerNumber' => 'payer-number',
            'account' => 'account',
            'donorId' => 'id',
            'name' => 'name',
            'address' => ['foobar'],
            'email' => 'email',
            'phone' => 'phone',
            'donationAmount' => '1',
            'comment' => 'comment',
            'type' => DonorSchema::TYPE_VERSION
        ]);
    }
}
