<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Xml;

use byrokrat\giroapp\Xml\XmlObject;
use byrokrat\giroapp\Exception\InvalidXmlException;
use byrokrat\giroapp\Validator\ValidatorInterface;
use PhpSpec\ObjectBehavior;
use PhpSpec\Exception\Example\FailureException;
use Prophecy\Argument;

class XmlObjectSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('<xml></xml>');
        $this->shouldHaveType(XmlObject::CLASS);
    }

    function it_fails_if_content_is_not_xml()
    {
        $this->beConstructedWith('this is not valid xml...');
        $this->shouldThrow(InvalidXmlException::CLASS)->duringInstantiation();
    }

    function it_can_be_cast_to_string()
    {
        $this->beConstructedWith('<a><b>foobar</b></a>');
        $this->asXml()->shouldContain('<a><b>foobar</b></a>');
    }

    function it_can_check_if_element_exists()
    {
        $this->beConstructedWith('<a><b/></a>');
        $this->shouldHaveElement('/a/b');
        $this->shouldNotHaveElement('c');
    }

    function it_can_read_element(ValidatorInterface $validator)
    {
        $this->beConstructedWith('<a><b>foo</b></a>');
        $validator->validate('/a/b', 'foo')->willReturn('bar')->shouldBeCalled();
        $this->readElement('/a/b', $validator)->shouldBeLike('bar');
    }

    function it_reads_content_from_first_element(ValidatorInterface $validator)
    {
        $this->beConstructedWith('<xml><a>foo</a><a>bar</a></xml>');
        $validator->validate('/xml/a', 'foo')->willReturn('foo');
        $this->readElement('/xml/a', $validator)->shouldBeLike('foo');
    }

    function it_fails_if_element_is_not_found(ValidatorInterface $validator)
    {
        $this->beConstructedWith('<xml></xml>');
        $this->shouldThrow(InvalidXmlException::CLASS)->duringReadElement('/xml/does/not/exist', $validator);
    }

    function it_can_iterate_over_elements()
    {
        $this->beConstructedWith(
            '<x><el><key>A</key><value>B</value></el><el><key>C</key><value>D</value></el></x>'
        );

        $this->getElements('/x/el')->shouldYieldXmlObjects([
            new XmlObject('<el><key>A</key><value>B</value></el>'),
            new XmlObject('<el><key>C</key><value>D</value></el>')
        ]);
    }

    function getMatchers(): array
    {
        return [
            'yieldXmlObjects' => function ($subject, $expected) {
                foreach ($subject as $index => $xml) {
                    if (!isset($expected[$index])) {
                        throw new FailureException("Unexpected xml object at index $index");
                    }

                    if ($xml->asXml() != $expected[$index]->asXml()) {
                        throw new FailureException(
                            sprintf(
                                'Invalid XML at index %s, found %s but expected %s',
                                $index,
                                $xml->asXml(),
                                $expected[$index]->asXml()
                            )
                        );
                    }
                }

                return true;
            }
        ];
    }
}
