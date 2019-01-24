<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Mapper\Schema\PostalAddressSchema;
use byrokrat\giroapp\State\StateCollection;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\giroapp\State\ActiveState;
use byrokrat\giroapp\Model\PostalAddress;
use byrokrat\giroapp\Model\Donor;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\amount\Currency\SEK;
use byrokrat\id\IdFactoryInterface;
use byrokrat\id\IdInterface;
use hanneskod\yaysondb\Expression\ExpressionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorSchemaSpec extends ObjectBehavior
{
    const MANDATE_KEY = 'mandate-key';
    const MANDATE_SOURCE = 'mandate-source';
    const PAYER_NUMBER = 'payer-number';
    const STATE = 'state';
    const STATE_DESC = 'state-desc';
    const NAME = 'name';
    const ACCOUNT = 'account';
    const ID = 'id';
    const ADDRESS = 'address';
    const EMAIL = 'email';
    const PHONE = 'phone';
    const AMOUNT = '100';
    const COMMENT = 'comment';
    const FORMATTED_DATE = '2017-11-04T13:25:19+01:00';
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
        'state_desc' => self::STATE_DESC,
        'name' => self::NAME,
        'account' => self::ACCOUNT,
        'donor_id' => self::ID,
        'address' => [self::ADDRESS],
        'email' => self::EMAIL,
        'phone' => self::PHONE,
        'donation_amount' => self::AMOUNT,
        'comment' => self::COMMENT,
        'created' => self::FORMATTED_DATE,
        'updated' => self::FORMATTED_DATE,
        'attributes' => [self::ATTR_KEY => self::ATTR_VALUE]
    ];

    function let(
        PostalAddressSchema $postalAddressSchema,
        PostalAddress $address,
        StateCollection $stateCollection,
        StateInterface $state,
        AccountFactoryInterface $accountFactory,
        AccountNumber $account,
        IdFactoryInterface $idFactory,
        IdInterface $id,
        \DateTimeImmutable $datetime
    ) {
        $postalAddressSchema->fromArray([self::ADDRESS])->willReturn($address);
        $postalAddressSchema->toArray($address)->willReturn([self::ADDRESS]);

        $stateCollection->getState(self::STATE)->willReturn($state);
        $state->getStateId()->willReturn(self::STATE);

        $accountFactory->createAccount(self::ACCOUNT)->willReturn($account);
        $account->getNumber()->willReturn(self::ACCOUNT);

        $idFactory->createId(self::ID)->willReturn($id);
        $id->format('S-sk')->willReturn(self::ID);

        $datetime->format(\DateTime::W3C)->willReturn(self::FORMATTED_DATE);

        $this->beConstructedWith(
            $postalAddressSchema,
            $stateCollection,
            $accountFactory,
            $idFactory
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorSchema::CLASS);
    }

    function it_can_create_donors($state, $account, $id, $address)
    {
        $this->fromArray($this->schemaDocument)->shouldBeLike(
            new Donor(
                self::MANDATE_KEY,
                $state->getWrappedObject(),
                self::STATE_DESC,
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
                new \DateTimeImmutable(self::FORMATTED_DATE),
                new \DateTimeImmutable(self::FORMATTED_DATE),
                [self::ATTR_KEY => self::ATTR_VALUE]
            )
        );
    }

    function it_can_create_arrays($account, $id, $address, $state, $datetime, SEK $amount)
    {
        $amount->getAmount()->willReturn(self::AMOUNT);

        $donor = new Donor(
            self::MANDATE_KEY,
            $state->getWrappedObject(),
            self::STATE_DESC,
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
            $datetime->getWrappedObject(),
            $datetime->getWrappedObject(),
            [self::ATTR_KEY => self::ATTR_VALUE]
        );

        $this->toArray($donor)->shouldBeLike($this->schemaDocument);
    }

    function it_contains_json_schema()
    {
        $this->getJsonSchema()->shouldBeObject();
    }
}
