<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\PayerNrFromPersonalIdPass;
use byrokrat\giroapp\Xml\XmlMandate;
use byrokrat\id\IdInterface;
use PhpSpec\ObjectBehavior;

class PayerNrFromPersonalIdPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PayerNrFromPersonalIdPass::class);
    }

    function it_sets_payer_number(IdInterface $donorId)
    {
        $donorId->format('Ssk')->willReturn('foobar');

        $input = new XmlMandate;
        $input->donorId = $donorId->getWrappedObject();

        $expected = clone $input;
        $expected->payerNumber = 'foobar';

        $this->processMandate($input)->shouldBeLike($expected);
    }
}
