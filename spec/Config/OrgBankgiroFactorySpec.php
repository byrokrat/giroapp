<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\OrgBankgiroFactory;
use byrokrat\giroapp\Config\NullOrgBankgiro;
use byrokrat\giroapp\Config\ConfigInterface;
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

    function it_delegates_creating_account($decorated, ConfigInterface $config, AccountNumber $account)
    {
        $config->getValue()->willReturn('foo');
        $decorated->createAccount('foo')->willReturn($account);
        $this->createAccount($config)->shouldReturn($account);
    }

    function it_creates_missing_org_bankgiro_on_failure($decorated, ConfigInterface $config)
    {
        $config->getValue()->willReturn('foo');
        $decorated->createAccount('foo')->willThrow(new InvalidAccountNumberException);
        $this->createAccount($config)->shouldHaveType(NullOrgBankgiro::CLASS);
    }
}
