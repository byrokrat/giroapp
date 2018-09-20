<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\MissingOrgBankgiro;
use byrokrat\giroapp\Exception\InvalidSettingException;
use byrokrat\banking\AccountNumber;
use byrokrat\banking\Formatter\FormatterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MissingOrgBankgiroSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MissingOrgBankgiro::CLASS);
    }

    function it_is_an_account_number()
    {
        $this->shouldHaveType(AccountNumber::CLASS);
    }

    function it_throws_exception_on_usage(FormatterInterface $formatter, AccountNumber $account)
    {
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getBankName');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getRawNumber');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('format', [$formatter]);
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getNumber');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('__toString');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('prettyprint');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('get16');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getClearingNumber');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getClearingCheckDigit');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getSerialNumber');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getCheckDigit');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('equals', [$account, false]);
    }
}
