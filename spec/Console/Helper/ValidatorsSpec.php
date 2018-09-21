<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Console\Helper;

use byrokrat\giroapp\Console\Helper\Validators;
use byrokrat\giroapp\State\StatePool;
use byrokrat\giroapp\State\StateInterface;
use byrokrat\amount\Currency\SEK;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use byrokrat\id\IdFactoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValidatorsSpec extends ObjectBehavior
{
    function let(
        AccountFactoryInterface $accountFactory,
        AccountFactoryInterface $bankgiroFactory,
        IdFactoryInterface $idFactory,
        StatePool $statePool
    ) {
        $this->beConstructedWith($accountFactory, $bankgiroFactory, $idFactory, $statePool);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Validators::CLASS);
    }

    function it_validates_donor_keys()
    {
        $this->getDonorKeyValidator()->shouldValidate('dhHjduey67839287');
        $this->getDonorKeyValidator()->shouldNotValidate('a.a');
    }

    function it_validates_amounts()
    {
        $this->getAmountValidator()->shouldValidate('123', new SEK('123'));
        $this->getAmountValidator()->shouldNotValidate('123.10');
    }

    function it_validates_accounts($accountFactory, AccountNumber $accountNumber)
    {
        $accountFactory->createAccount('123')->willReturn($accountNumber);
        $accountFactory->createAccount('456')->willThrow(\RuntimeException::CLASS);
        $this->getAccountValidator()->shouldValidate('123');
        $this->getAccountValidator()->shouldNotValidate('456');
    }

    function it_validates_bankgiro_accounts($bankgiroFactory, AccountNumber $bankgiro)
    {
        $bankgiroFactory->createAccount('123')->willReturn($bankgiro);
        $bankgiroFactory->createAccount('456')->willThrow(\RuntimeException::CLASS);
        $this->getBankgiroValidator()->shouldValidate('123');
        $this->getBankgiroValidator()->shouldNotValidate('456');
    }

    function it_validates_ids($idFactory, IdInterface $id)
    {
        $idFactory->createId('123')->willReturn($id);
        $idFactory->createId('456')->willThrow(\RuntimeException::CLASS);
        $this->getIdValidator()->shouldValidate('123');
        $this->getIdValidator()->shouldNotValidate('456');
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

    function it_validates_choice_questions()
    {
        $this->getChoiceValidator(['key' => 'value'])->shouldValidate('key', 'value');
        $this->getChoiceValidator(['key' => 'value'])->shouldValidate('KEY', 'value');
        $this->getChoiceValidator(['key' => 'value'])->shouldValidate('value', 'value');
        $this->getChoiceValidator(['key' => 'value'])->shouldNotValidate('something-else');
    }

    function it_validates_donor_states($statePool, StateInterface $state)
    {
        $statePool->getState('valid')->willReturn($state)->shouldBeCalled();
        $statePool->getState('unvalid')->willThrow(\RuntimeException::CLASS)->shouldBeCalled();
        $this->getStateValidator(['valid'])->shouldValidate('valid');
        $this->getStateValidator(['valid'])->shouldNotValidate('unvalid');
        $this->getStateValidator(['unvalid'])->shouldNotValidate('unvalid');
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
