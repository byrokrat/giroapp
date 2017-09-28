<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Mapper\Schema\PostalAddressSchema;
use byrokrat\giroapp\State\StateFactory;
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
        'type' => DonorSchema::TYPE_VERSION,
        'mandateKey' => self::MANDATE_KEY,
        'mandateSource' => self::MANDATE_SOURCE,
        'payerNumber' => self::PAYER_NUMBER,
        'state' => self::STATE,
        'name' => self::NAME,
        'account' => self::ACCOUNT,
        'donorId' => self::ID,
        'address' => [self::ADDRESS],
        'email' => self::EMAIL,
        'phone' => self::PHONE,
        'donationAmount' => self::AMOUNT,
        'comment' => self::COMMENT,
        'attributes' => [self::ATTR_KEY => self::ATTR_VALUE]
    ];

    function let(
        PostalAddressSchema $postalAddressSchema,
        StateFactory $stateFactory,
        AccountFactory $accountFactory,
        IdFactory $idFactory
    ) {
        $this->beConstructedWith(
            $postalAddressSchema,
            $stateFactory,
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
        $stateFactory,
        $accountFactory,
        $idFactory,
        StateInterface $state,
        AccountNumber $account,
        PersonalId $id,
        PostalAddress $address
    ) {
        $postalAddressSchema->fromArray([self::ADDRESS])->willReturn($address);
        $stateFactory->createState(self::STATE)->willReturn($state);
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
        $state->getId()->willReturn(self::STATE);
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

    function it_can_create_payer_number_search_expressions()
    {
        $this->getPayerNumberSearchExpression('1234')->shouldMatchDocument([
            'payerNumber' => '1234'
        ]);

        $this->getPayerNumberSearchExpression('1234')->shouldNotMatchDocument([
            'payerNumber' => 'not-1234'
        ]);

        $this->getPayerNumberSearchExpression('1234')->shouldNotMatchDocument([
            'not-payer-number' => '1234'
        ]);
    }

    function it_can_create_mandate_key_search_expressions()
    {
        $this->getMandateKeySearchExpression('1234')->shouldMatchDocument([
            'mandateKey' => '1234'
        ]);

        $this->getMandateKeySearchExpression('1234')->shouldNotMatchDocument([
            'mandateKey' => 'not-1234'
        ]);

        $this->getMandateKeySearchExpression('1234')->shouldNotMatchDocument([
            'not-mandate-key' => '1234'
        ]);
    }

    function getMatchers()
    {
        return [
            'matchDocument' => function (ExpressionInterface $expression, $doc) {
                return $expression->evaluate($doc);
            },
            'notMatchDocument' => function (ExpressionInterface $expression, $doc) {
                return !$expression->evaluate($doc);
            }
        ];
    }
}
