<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Utils;

use byrokrat\giroapp\Utils\OrgIdFactory;
use byrokrat\giroapp\Utils\MissingOrgId;
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

    function it_is_an_id_factory()
    {
        $this->shouldHaveType(IdFactoryInterface::CLASS);
    }

    function it_delegates_creating_account($decorated, IdInterface $id)
    {
        $decorated->createId('foo')->willReturn($id);
        $this->createId('foo')->shouldReturn($id);
    }

    function it_creates_missing_org_bankgiro_on_failure($decorated)
    {
        $decorated->createId('foo')->willThrow(new UnableToCreateIdException);
        $this->createId('foo')->shouldHaveType(MissingOrgId::CLASS);
    }
}
