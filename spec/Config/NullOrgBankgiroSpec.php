<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\NullOrgBankgiro;
use byrokrat\giroapp\Exception\InvalidConfigException;
use byrokrat\banking\AccountNumber;
use byrokrat\banking\Formatter\FormatterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NullOrgBankgiroSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NullOrgBankgiro::CLASS);
    }

    function it_is_an_account_number()
    {
        $this->shouldHaveType(AccountNumber::CLASS);
    }

    function it_throws_exception_on_usage(FormatterInterface $formatter, AccountNumber $account)
    {
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getBankName');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getRawNumber');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('format', [$formatter]);
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getNumber');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('prettyprint');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('get16');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getClearingNumber');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getClearingCheckDigit');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getSerialNumber');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getCheckDigit');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('equals', [$account, false]);
    }

    function it_has_a_string_representations()
    {
        $this->__toString()->shouldReturn('');
    }
}
