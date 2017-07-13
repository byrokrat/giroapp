<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Arrayizer;

use byrokrat\giroapp\Mapper\Arrayizer\DonorArrayizer;
use byrokrat\giroapp\Mapper\Arrayizer\PostalAddressArrayizer;
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

class DonorArrayizerSpec extends ObjectBehavior
{
    function let(
        PostalAddressArrayizer $postalAddressArrayizer,
        DonorStateFactory $donorStateFactory,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {

        $this->beConstructedWith(
            $postalAddressArrayizer,
            $donorStateFactory,
            $accountFactory,
            $idFactory
        );
    }  
    function it_is_initializable()
    {
        $this->shouldHaveType(DonorArrayizer::CLASS);
    }

    function it_can_create_donor(
        $postalAddressArrayizer,
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

        $postalAddressArrayizer->fromArray(['foobar'])->willReturn($address);
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
        $postalAddressArrayizer,
        AccountNumber $account,
        PersonalId $id,
        PostalAddress $address,
        DonorState $donorState,
        SEK $amount
    ) {
        $postalAddressArrayizer->toArray($address)->willReturn(['foobar']);
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
            'type' => DonorArrayizer::TYPE_VERSION
        ]);
    }
}
