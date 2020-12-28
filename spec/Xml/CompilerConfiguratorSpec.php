<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\CompilerConfigurator;
use byrokrat\giroapp\Xml\XmlMandateCompiler;
use Money\MoneyParser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CompilerConfiguratorSpec extends ObjectBehavior
{
    function let(MoneyParser $moneyParser)
    {
        $this->beConstructedWith('', '', '', '', '', $moneyParser);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CompilerConfigurator::class);
    }

    function it_loads_passes(XmlMandateCompiler $compiler)
    {
        $compiler->addCompilerPass(Argument::any())->shouldBeCalled();
        $this->loadCompilerPasses($compiler);
    }
}
