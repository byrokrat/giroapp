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
        'mandateKey' => 'foobar',
        'state' => 'foobar',
        'mandateSource' => 'foobar',
        'payerNumber' => 'foobar',
        'account' => 'foobar',
        'id' => 'foobar',
        'name' => 'foobar',
        'address' => ['foobar'],
        'donationAmount' => '1',
        'comment' => 'foobar'
        ];

        $postalAddressSchema->fromArray(['foobar'])->willReturn($address);
        $donorStateFactory->createDonorState('foobar')->willReturn($donorState);
        $accountFactory->createAccount('foobar')->willReturn($account);
        $idFactory->create('foobar')->willReturn($id);

        $this->fromArray($doc)->shouldBeLike(
            new Donor(
                'foobar',
                $donorState->getWrappedObject(),
                'foobar',
                'foobar',
                $account->getWrappedObject(),
                $id->getWrappedObject(),
                'foobar',
                $address->getWrappedObject(),
                new SEK('1'),
                'foobar'
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
        $account->getNumber()->willReturn('foobar');
        $id->format('S-sk')->willReturn('foobar');
        $amount->getAmount()->willReturn('1');

        $donor = new Donor(
            'foobar',
            $donorState->getWrappedObject(),
            'foobar',
            'foobar',
            $account->getWrappedObject(),
            $id->getWrappedObject(),
            'foobar',
            $address->getWrappedObject(),
            new SEK('1'),
            'foobar'
        );

        $this->toArray($donor)->shouldBeLike([
            'mandateKey' => 'foobar',
            'state' => 'ActiveState',
            'mandateSource' => 'foobar',
            'payerNumber' => 'foobar',
            'account' => 'foobar',
            'donorId' => 'foobar',
            'name' => 'foobar',
            'address' => ['foobar'],
            'email' => '',
            'phone' => '',
            'donationAmount' => '1',
            'comment' => 'foobar',
            'type' => DonorSchema::TYPE_VERSION
        ]);
    }
}
