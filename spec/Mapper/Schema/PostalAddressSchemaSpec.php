<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Mapper\Schema\PostalAddressSchema;
use byrokrat\giroapp\Model\PostalAddress;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostalAddressSchemaSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PostalAddressSchema::CLASS);
    }

    function it_can_create_postaladdress()
    {
        $doc = array(
        'postalCode' => '12345',
        'postalCity' => 'aaaa',
        'address1' => 'bbbb',
        'address2' => 'cccc',
        'coAddress' => 'dddd');

        $this->fromArray($doc)->shouldBeLike(new PostalAddress(
            '12345',
            'aaaa',
            'bbbb',
            'cccc',
            'dddd'
        ));
    }

    function it_can_create_arrays()
    {
        $postalAddress = new PostalAddress(
            '12345',
            'aaaa',
            'bbbb',
            'cccc',
            'dddd'
        );
        $this->toArray($postalAddress)->shouldBeLike([
            'postalCode' => '12345',
            'postalCity' => 'aaaa',
            'address1' => 'bbbb',
            'address2' => 'cccc',
            'coAddress' => 'dddd',
            'type' => PostalAddressSchema::TYPE_VERSION
        ]);
    }
}
