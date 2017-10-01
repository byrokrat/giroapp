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

    function it_can_create_address()
    {
        $doc = [
            'line1' => '1',
            'line2' => '2',
            'line3' => '3',
            'postal_code' => 'code',
            'postal_city' => 'city'
        ];

        $this->fromArray($doc)->shouldBeLike(
            new PostalAddress('1', '2', '3', 'code', 'city')
        );
    }

    function it_can_create_array()
    {
        $this->toArray(new PostalAddress('1', '2', '3', 'code', 'city'))->shouldBeLike([
            'type' => PostalAddressSchema::TYPE,
            'line1' => '1',
            'line2' => '2',
            'line3' => '3',
            'postal_code' => 'code',
            'postal_city' => 'city'
        ]);
    }
}
