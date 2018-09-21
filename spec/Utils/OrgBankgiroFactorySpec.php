<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\OrgBankgiroFactory;
use byrokrat\giroapp\Utils\MissingOrgBankgiro;
use byrokrat\banking\AccountFactoryInterface;
use byrokrat\banking\AccountNumber;
use byrokrat\banking\Exception\InvalidAccountNumberException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrgBankgiroFactorySpec extends ObjectBehavior
{
    function let(AccountFactoryInterface $decorated)
    {
        $this->beConstructedWith($decorated);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrgBankgiroFactory::CLASS);
    }

    function it_is_an_account_factory()
    {
        $this->shouldHaveType(AccountFactoryInterface::CLASS);
    }

    function it_delegates_creating_account($decorated, AccountNumber $account)
    {
        $decorated->createAccount('foo')->willReturn($account);
        $this->createAccount('foo')->shouldReturn($account);
    }

    function it_creates_missing_org_bankgiro_on_failure($decorated)
    {
        $decorated->createAccount('foo')->willThrow(new InvalidAccountNumberException);
        $this->createAccount('foo')->shouldHaveType(MissingOrgBankgiro::CLASS);
    }
}
