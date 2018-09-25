<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Config;

use byrokrat\giroapp\Config\OrgIdFactory;
use byrokrat\giroapp\Config\NullOrgId;
use byrokrat\giroapp\Config\ConfigInterface;
use byrokrat\id\IdFactoryInterface;
use byrokrat\id\IdInterface;
use byrokrat\id\Exception\UnableToCreateIdException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrgIdFactorySpec extends ObjectBehavior
{
    function let(IdFactoryInterface $decorated)
    {
        $this->beConstructedWith($decorated);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrgIdFactory::CLASS);
    }

    function it_delegates_creating_account($decorated, ConfigInterface $config, IdInterface $id)
    {
        $config->getValue()->willReturn('foo');
        $decorated->createId('foo')->willReturn($id);
        $this->createId($config)->shouldReturn($id);
    }

    function it_creates_missing_org_bankgiro_on_failure($decorated, ConfigInterface $config)
    {
        $config->getValue()->willReturn('foo');
        $decorated->createId('foo')->willThrow(new UnableToCreateIdException);
        $this->createId($config)->shouldHaveType(NullOrgId::CLASS);
    }
}
