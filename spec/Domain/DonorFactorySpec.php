<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Domain;

use byrokrat\giroapp\Domain\DonorFactory;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Domain\PostalAddress;
use byrokrat\giroapp\Domain\State\StateCollection;
use byrokrat\giroapp\Domain\State\StateInterface;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\amount\Currency\SEK;
use byrokrat\id\IdFactoryInterface;
use byrokrat\id\IdInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorFactorySpec extends ObjectBehavior
{
    function let(
        StateCollection $stateCollection,
        AccountFactoryInterface $accountFactory,
        IdFactoryInterface $idFactory
    ) {
        $this->beConstructedWith($stateCollection, $accountFactory, $idFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorFactory::CLASS);
    }

    function it_creates_minimal_donor(
        $stateCollection,
        $accountFactory,
        $idFactory,
        StateInterface $state,
        AccountNumber $account,
        IdInterface $id
    ) {
        $stateCollection->getState('')->willReturn($state);
        $accountFactory->createAccount('')->willReturn($account);
        $idFactory->createId('')->willReturn($id);
        $this->createDonor()->shouldHaveType(Donor::CLASS);
    }

    function it_reads_values(
        $stateCollection,
        $accountFactory,
        $idFactory,
        StateInterface $state,
        AccountNumber $account,
        IdInterface $id
    ) {
        $stateCollection->getState('state')->willReturn($state);
        $accountFactory->createAccount('account')->willReturn($account);
        $idFactory->createId('id')->willReturn($id);

        $this->createDonor(
            'key',
            'state',
            'source',
            'payer_number',
            'account',
            'id',
            'name',
            ['address'],
            'email',
            'phone',
            '100',
            'comment',
            '2017-11-04T13:25:19+01:00',
            '2018-11-04T13:25:19+01:00',
            ['attributes']
        )->shouldBeLike(new Donor(
            'key',
            $state->getWrappedObject(),
            'source',
            'payer_number',
            $account->getWrappedObject(),
            $id->getWrappedObject(),
            'name',
            new PostalAddress('address'),
            'email',
            'phone',
            new SEK('100'),
            'comment',
            new \DateTimeImmutable('2017-11-04T13:25:19+01:00'),
            new \DateTimeImmutable('2018-11-04T13:25:19+01:00'),
            ['attributes']
        ));
    }
}
