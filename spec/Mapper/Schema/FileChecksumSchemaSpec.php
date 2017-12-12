<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper\Schema;

use byrokrat\giroapp\Mapper\Schema\FileChecksumSchema;
use byrokrat\giroapp\Model\FileChecksum;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileChecksumSchemaSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FileChecksumSchema::CLASS);
    }

    function it_can_create_checksums(\DateTime $date)
    {
        $doc = [
            'filename' => 'fname',
            'checksum' => 'checksum',
            'datetime' => '2017-11-04T13:25:19+01:00'
        ];

        $this->fromArray($doc)->shouldBeLike(
            new FileChecksum('fname', 'checksum', new \DateTimeImmutable('2017-11-04T13:25:19+01:00'))
        );
    }

    function it_can_create_array()
    {
        $checksum = new FileChecksum('fname', 'checksum', new \DateTimeImmutable('2017-11-04T13:25:19+01:00'));
        $this->toArray($checksum)->shouldBeLike([
            'type' => FileChecksumSchema::TYPE,
            'filename' => 'fname',
            'checksum' => 'checksum',
            'datetime' => '2017-11-04T13:25:19+01:00'
        ]);
    }
}
