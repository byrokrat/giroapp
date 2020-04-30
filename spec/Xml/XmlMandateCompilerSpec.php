<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlMandateCompiler;
use byrokrat\giroapp\Xml\XmlMandateParser;
use byrokrat\giroapp\Xml\XmlMandate;
use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Xml\CompilerPassInterface;
use PhpSpec\ObjectBehavior;

class XmlMandateCompilerSpec extends ObjectBehavior
{
    function let(XmlMandateParser $parser)
    {
        $this->beConstructedWith($parser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(XmlMandateCompiler::class);
    }

    function it_does_simple_compilation($parser, XmlObject $root, XmlMandate $mandate)
    {
        $parser->parseXml($root)->willReturn([$mandate]);
        $this->compileMandates($root)->shouldReturn([$mandate]);
    }

    function it_uses_compiler_passes($parser, XmlObject $root, XmlMandate $mandate, CompilerPassInterface $pass)
    {
        $parser->parseXml($root)->willReturn([$mandate]);

        $this->addCompilerPass($pass);

        $pass->processMandate($mandate)->willReturn($mandate)->shouldBeCalled();

        $this->compileMandates($root)->shouldReturn([$mandate]);
    }
}
