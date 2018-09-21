<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\MissingOrgId;
use byrokrat\giroapp\Exception\InvalidSettingException;
use byrokrat\id\IdInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MissingOrgIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MissingOrgId::CLASS);
    }

    function it_is_an_id()
    {
        $this->shouldHaveType(IdInterface::CLASS);
    }

    function it_throws_exception_on_usage()
    {
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getId');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('__tostring');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('format', ['']);
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getSerialPreDelimiter');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getSerialPostDelimiter');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getDelimiter');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getCheckDigit');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getBirthDate', [new \DateTimeImmutable]);
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getAge');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getCentury');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getSex');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isMale');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isFemale');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isSexOther');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isSexUndefined');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getBirthCounty');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('getLegalForm');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isLegalFormUndefined');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isStateOrParish');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isIncorporated');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isPartnership');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isAssociation');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isNonProfit');
        $this->shouldThrow(InvalidSettingException::CLASS)->during('isTradingCompany');
    }
}
