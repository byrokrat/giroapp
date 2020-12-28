<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\EmailFromAttributePass;
use byrokrat\giroapp\Xml\XmlMandate;
use PhpSpec\ObjectBehavior;

class EmailFromAttributePassSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('attr-key');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EmailFromAttributePass::class);
    }

    function it_ignore_unknown_attr()
    {
        $input = new XmlMandate();
        $this->processMandate($input)->shouldBeLike($input);
    }

    function it_sets_value_from_attr()
    {
        $input = new XmlMandate();
        $input->attributes['attr-key'] = 'foobar';

        $expected = clone $input;
        $expected->email = 'foobar';

        $this->processMandate($input)->shouldBeLike($expected);
    }
}
