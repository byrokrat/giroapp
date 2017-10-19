<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Console\Helper\Validators;
use byrokrat\giroapp\State\StateFactory;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\amount\Currency\SEK;
use byrokrat\banking\AccountFactory;
use byrokrat\banking\AccountNumber;
use byrokrat\banking\Bankgiro;
use byrokrat\banking\BankgiroFactory;
use byrokrat\id\Id;
use byrokrat\id\IdFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidatorsSpec extends ObjectBehavior
{

    function let(
        AccountFactory $accountFactory,
        BankgiroFactory $bankgiroFactory,
        IdFactory $idFactory,
        StateFactory $stateFactory
    ) {
        $this->beConstructedWith($accountFactory, $bankgiroFactory, $idFactory, $stateFactory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Validators::CLASS);
    }

    function it_validates_amounts()
    {
        $this->getAmountValidator()->shouldValidate('123', new SEK('123'));
        $this->getAmountValidator()->shouldNotValidate('123.10');
    }

    function it_validates_accounts($accountFactory, AccountNumber $accountNumber)
    {
        $accountFactory->createAccount('a-valid-account')->willReturn($accountNumber);
        $accountFactory->createAccount('an-unvalid-account')->willThrow(\RuntimeException::CLASS);
        $this->getAccountValidator()->shouldValidate('a-valid-account');
        $this->getAccountValidator()->shouldNotValidate('an-unvalid-account');
    }

    function it_validates_bankgiro_accounts($bankgiroFactory, Bankgiro $bankgiro)
    {
        $bankgiroFactory->createAccount('a-valid-account')->willReturn($bankgiro);
        $bankgiroFactory->createAccount('an-unvalid-account')->willThrow(\RuntimeException::CLASS);
        $this->getBankgiroValidator()->shouldValidate('a-valid-account');
        $this->getBankgiroValidator()->shouldNotValidate('an-unvalid-account');
    }

    function it_validates_ids($idFactory, Id $id)
    {
        $idFactory->create('a-valid-id')->willReturn($id);
        $idFactory->create('an-unvalid-id')->willThrow(\RuntimeException::CLASS);
        $this->getIdValidator()->shouldValidate('a-valid-id');
        $this->getIdValidator()->shouldNotValidate('an-unvalid-id');
    }

    function it_validates_donor_states($stateFactory, StateInterface $state)
    {
        $stateFactory->createState('a-valid-state')->willReturn($state);
        $stateFactory->createState('an-unvalid-state')->willThrow(\RuntimeException::CLASS);
        $this->getStateValidator()->shouldValidate('a-valid-state');
        $this->getStateValidator()->shouldNotValidate('an-unvalid-state');
    }

    function it_validates_bgc_customer_numbers()
    {
        $this->getBgcCustomerNumberValidator()->shouldValidate('123456');
        $this->getBgcCustomerNumberValidator()->shouldNotValidate('qwerty');
        $this->getBgcCustomerNumberValidator()->shouldNotValidate('123');
    }

    function it_validates_payer_numbers()
    {
        $this->getPayerNumberValidator()->shouldValidate('123456');
        $this->getPayerNumberValidator()->shouldNotValidate('qwerty');
        $this->getPayerNumberValidator()->shouldNotValidate('12345678901234567');
    }

    function it_validates_email_addresses()
    {
        $this->getEmailValidator()->shouldValidate('test@test.com');
        $this->getEmailValidator()->shouldValidate('');
        $this->getEmailValidator()->shouldNotValidate('not-an-address');
    }

    function it_validates_phone_number()
    {
        $this->getPhoneValidator()->shouldValidate('+46 (0) 70-123 123');
        $this->getPhoneValidator()->shouldValidate('');
        $this->getPhoneValidator()->shouldNotValidate('not-a-number');
    }

    function it_validates_postal_codes()
    {
        $this->getPostalCodeValidator()->shouldValidate(' 123 45 ', '12345');
        $this->getPostalCodeValidator()->shouldValidate('');
        $this->getPostalCodeValidator()->shouldNotValidate('not-a-number');
    }

    function it_validates_strings()
    {
        $this->getStringFilter()->shouldValidate(chr(1) . 'foobar', 'foobar');
        $this->getStringFilter()->shouldValidate('malmö', 'malmö');
        $this->getStringFilter()->shouldValidate('');
    }

    function it_validates_required_strings()
    {
        $this->getRequiredStringValidator('field')->shouldValidate(chr(1) . 'foobar', 'foobar');
        $this->getRequiredStringValidator('field')->shouldValidate('malmö', 'malmö');
        $this->getRequiredStringValidator('field')->shouldNotValidate('');
    }

    function it_contains_suggested_cities()
    {
        $this->getSuggestedCities()->shouldBeArray();
    }

    public function getMatchers(): array
    {
        return [
            'validate' => function ($validator, $raw, $expected = null) {
                try {
                    $validated = $validator($raw);
                    return is_null($expected) ? true : $validated == $expected;
                } catch (\Exception $e) {
                    return false;
                }
            }
        ];
    }
}
