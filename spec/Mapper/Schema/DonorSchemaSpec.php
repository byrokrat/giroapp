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
    /**
     * @var array A schema formatted document to test against
     */
    private $schemaDocument = [
        'type' => DonorSchema::TYPE_VERSION,
        'mandateKey' => 'mandate-key',
        'state' => 'state',
        'mandateSource' => 'mandate-source',
        'payerNumber' => 'payer-number',
        'account' => 'account',
        'donorId' => 'id',
        'name' => 'name',
        'address' => ['foobar'],
        'email' => 'email',
        'phone' => 'phone',
        'donationAmount' => '1',
        'comment' => 'comment'
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
        $postalAddressSchema->fromArray(['foobar'])->willReturn($address);
        $stateFactory->createState('state')->willReturn($state);
        $accountFactory->createAccount('account')->willReturn($account);
        $idFactory->create('id')->willReturn($id);

        $this->fromArray($this->schemaDocument)->shouldBeLike(
            new Donor(
                'mandate-key',
                $state->getWrappedObject(),
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
        StateInterface $state,
        SEK $amount
    ) {
        $postalAddressSchema->toArray($address)->willReturn(['foobar']);
        $state->getId()->willReturn('state');
        $account->getNumber()->willReturn('account');
        $id->format('S-sk')->willReturn('id');
        $amount->getAmount()->willReturn('1');

        $donor = new Donor(
            'mandate-key',
            $state->getWrappedObject(),
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
