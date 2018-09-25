<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\NullOrgId;
use byrokrat\giroapp\Exception\InvalidConfigException;
use byrokrat\id\IdInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NullOrgIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NullOrgId::CLASS);
    }

    function it_is_an_id()
    {
        $this->shouldHaveType(IdInterface::CLASS);
    }

    function it_throws_exception_on_usage()
    {
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getId');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('__tostring');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('format', ['']);
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getSerialPreDelimiter');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getSerialPostDelimiter');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getDelimiter');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getCheckDigit');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getBirthDate', [new \DateTimeImmutable]);
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getAge');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getCentury');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getSex');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isMale');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isFemale');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isSexOther');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isSexUndefined');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getBirthCounty');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('getLegalForm');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isLegalFormUndefined');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isStateOrParish');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isIncorporated');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isPartnership');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isAssociation');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isNonProfit');
        $this->shouldThrow(InvalidConfigException::CLASS)->during('isTradingCompany');
    }
}
