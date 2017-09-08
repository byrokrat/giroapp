<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\NullXmlMandateMigation;
use byrokrat\giroapp\Xml\XmlMandateMigrationInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NullXmlMandateMigationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(NullXmlMandateMigation::CLASS);
    }

    function it_implements_migration_interface()
    {
        $this->shouldHaveType(XmlMandateMigrationInterface::CLASS);
    }

    function it_returns_an_empty_map()
    {
        $this->getXmlMigrationMap()->shouldReturn([]);
    }
}
