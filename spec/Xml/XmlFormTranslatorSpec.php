<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlFormTranslator;
use byrokrat\giroapp\Xml\XmlFormInterface;
use byrokrat\giroapp\Builder\DonorBuilder;
use byrokrat\giroapp\Exception\InvalidXmlFormException;
use byrokrat\amount\Currency\SEK;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlFormTranslatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(XmlFormTranslator::CLASS);
    }

    function it_sets_attribute_if_key_is_not_translated(XmlFormInterface $xmlForm, DonorBuilder $donorBuilder)
    {
        $xmlForm->getName()->willReturn('formId');
        $xmlForm->getTranslations()->willReturn([]);
        $this->addXmlForm($xmlForm);
        $donorBuilder->setAttribute('key', 'value')->shouldBeCalled();
        $this->writeValue($donorBuilder, 'formId', 'key', 'value');
    }

    function it_throws_exception_on_invalid_translation_map(XmlFormInterface $xmlForm, DonorBuilder $donorBuilder)
    {
        $xmlForm->getName()->willReturn('f');
        $xmlForm->getTranslations()->willReturn(['foo' => 'not-a-callable...']);
        $this->addXmlForm($xmlForm);
        $this->shouldThrow(InvalidXmlFormException::CLASS)->duringWriteValue($donorBuilder, 'f', '', '');
    }

    function it_runs_callable_if_defined(XmlFormInterface $xmlForm, DonorBuilder $donorBuilder)
    {
        $xmlForm->getName()->willReturn('formId');
        $xmlForm->getTranslations()->willReturn([
            'foo' => function (DonorBuilder $donorBuilder, string $value) {
                $donorBuilder->setAttribute('bar', 'callable-action');
            }
        ]);

        $this->addXmlForm($xmlForm);

        $donorBuilder->setAttribute('bar', 'callable-action')->shouldBeCalled();

        $this->writeValue($donorBuilder, 'formId', 'foo', 'ignored...');
    }

    function it_sets_phone_numbers(XmlFormInterface $xmlForm, DonorBuilder $donorBuilder)
    {
        $xmlForm->getName()->willReturn('formId');
        $xmlForm->getTranslations()->willReturn(['phone' => XmlFormInterface::PHONE]);
        $this->addXmlForm($xmlForm);
        $donorBuilder->setPhone('12345')->shouldBeCalled();
        $this->writeValue($donorBuilder, 'formId', 'phone', '12345');
    }

    function it_sets_mail_addresses(XmlFormInterface $xmlForm, DonorBuilder $donorBuilder)
    {
        $xmlForm->getName()->willReturn('formId');
        $xmlForm->getTranslations()->willReturn(['mail' => XmlFormInterface::EMAIL]);
        $this->addXmlForm($xmlForm);
        $donorBuilder->setEmail('foo@bar.com')->shouldBeCalled();
        $this->writeValue($donorBuilder, 'formId', 'mail', 'foo@bar.com');
    }

    function it_sets_amounts(XmlFormInterface $xmlForm, DonorBuilder $donorBuilder)
    {
        $xmlForm->getName()->willReturn('formId');
        $xmlForm->getTranslations()->willReturn(
            ['amount' => XmlFormInterface::DONATION_AMOUNT]
        );
        $this->addXmlForm($xmlForm);
        $donorBuilder->setDonationAmount(new SEK('100'))->shouldBeCalled();
        $this->writeValue($donorBuilder, 'formId', 'amount', '100');
    }

    function it_sets_comments(XmlFormInterface $xmlForm, DonorBuilder $donorBuilder)
    {
        $xmlForm->getName()->willReturn('formId');
        $xmlForm->getTranslations()->willReturn(
            ['comment' => XmlFormInterface::COMMENT]
        );
        $this->addXmlForm($xmlForm);
        $donorBuilder->setComment('foobar')->shouldBeCalled();
        $this->writeValue($donorBuilder, 'formId', 'comment', 'foobar');
    }
}
