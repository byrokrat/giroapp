<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Mapper\Schema\PostalAddressSchema;
use byrokrat\giroapp\State\StatePool;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\ActiveState;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Model\Donor;
use byrokrat\banking\AccountFactory;
use byrokrat\banking\AccountNumber;
use byrokrat\amount\Currency\SEK;
use byrokrat\id\IdFactory;
use byrokrat\id\PersonalId;
use hanneskod\yaysondb\Expression\ExpressionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorSchemaSpec extends ObjectBehavior
{
    const MANDATE_KEY = 'mandate-key';
    const MANDATE_SOURCE = 'mandate-source';
    const PAYER_NUMBER = 'payer-number';
    const STATE = 'state';
    const NAME = 'name';
    const ACCOUNT = 'account';
    const ID = 'id';
    const ADDRESS = 'address';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const AMOUNT = '100';
    const COMMENT = 'comment';
    const ATTR_KEY = 'ATTR_KEY';
    const ATTR_VALUE = 'ATTR_VALUE';

    /**
     * @var array A schema formatted document to test against
     */
    private $schemaDocument = [
        'type' => DonorSchema::TYPE,
        'mandate_key' => self::MANDATE_KEY,
        'mandate_source' => self::MANDATE_SOURCE,
        'payer_number' => self::PAYER_NUMBER,
        'state' => self::STATE,
        'name' => self::NAME,
        'account' => self::ACCOUNT,
        'donor_id' => self::ID,
        'address' => [self::ADDRESS],
        'email' => self::EMAIL,
        'phone' => self::PHONE,
        'donation_amount' => self::AMOUNT,
        'comment' => self::COMMENT,
        'attributes' => [self::ATTR_KEY => self::ATTR_VALUE]
    ];

    function let(
        PostalAddressSchema $postalAddressSchema,
        StatePool $statePool,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->beConstructedWith(
            $postalAddressSchema,
            $statePool,
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
        $statePool,
        $accountFactory,
        $idFactory,
        StateInterface $state,
        AccountNumber $account,
        PersonalId $id,
        PostalAddress $address
    ) {
        $postalAddressSchema->fromArray([self::ADDRESS])->willReturn($address);
        $statePool->getState(self::STATE)->willReturn($state);
        $accountFactory->createAccount(self::ACCOUNT)->willReturn($account);
        $idFactory->create(self::ID)->willReturn($id);

        $this->fromArray($this->schemaDocument)->shouldBeLike(
            new Donor(
                self::MANDATE_KEY,
                $state->getWrappedObject(),
                self::MANDATE_SOURCE,
                self::PAYER_NUMBER,
                $account->getWrappedObject(),
                $id->getWrappedObject(),
                self::NAME,
                $address->getWrappedObject(),
                self::EMAIL,
                self::PHONE,
                new SEK(self::AMOUNT),
                self::COMMENT,
                [self::ATTR_KEY => self::ATTR_VALUE]
            )
        );
    }

    function it_can_create_array(
        $postalAddressSchema,
        AccountNumber $account,
        PersonalId $id,
        PostalAddress $address,
        StateInterface $state,
        SEK $amount
    ) {
        $postalAddressSchema->toArray($address)->willReturn([self::ADDRESS]);
        $state->getStateId()->willReturn(self::STATE);
        $account->getNumber()->willReturn(self::ACCOUNT);
        $id->format('S-sk')->willReturn(self::ID);
        $amount->getAmount()->willReturn(self::AMOUNT);

        $donor = new Donor(
            self::MANDATE_KEY,
            $state->getWrappedObject(),
            self::MANDATE_SOURCE,
            self::PAYER_NUMBER,
            $account->getWrappedObject(),
            $id->getWrappedObject(),
            self::NAME,
            $address->getWrappedObject(),
            self::EMAIL,
            self::PHONE,
            $amount->getWrappedObject(),
            self::COMMENT,
            [self::ATTR_KEY => self::ATTR_VALUE]
        );

        $this->toArray($donor)->shouldBeLike($this->schemaDocument);
    }
}
