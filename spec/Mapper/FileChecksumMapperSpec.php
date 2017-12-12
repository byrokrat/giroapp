<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\FileChecksumMapper;
use byrokrat\giroapp\Mapper\Schema\FileChecksumSchema;
use byrokrat\giroapp\Model\FileChecksum;
use hanneskod\yaysondb\CollectionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileChecksumMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection, FileChecksumSchema $checksumSchema)
    {
        $this->beConstructedWith($collection, $checksumSchema);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FileChecksumMapper::CLASS);
    }

    function it_can_check_if_checksums_exist($collection)
    {
        $collection->has('check')->willReturn(false);
        $this->hasKey('check')->shouldReturn(false);
    }

    function it_can_read_checksums($collection, $checksumSchema, FileChecksum $fileChecksum)
    {
        $collection->has('check')->willReturn(true);
        $collection->read('check')->willReturn(['array']);
        $checksumSchema->fromArray(['array'])->willReturn($fileChecksum);
        $this->findByKey('check')->shouldReturn($fileChecksum);
    }

    function it_fail_reading_if_checksum_does_not_exist($collection)
    {
        $collection->has('check')->willReturn(false);
        $this->shouldThrow(\RuntimeException::CLASS)->duringFindByKey('check');
    }

    function it_can_save_new_checksums($collection, $checksumSchema, FileChecksum $fileChecksum)
    {
        $fileChecksum->getChecksum()->willReturn('check');
        $collection->has('check')->willReturn(false);
        $checksumSchema->toArray($fileChecksum)->willReturn(['doc']);
        $collection->insert(['doc'], 'check')->shouldBeCalled();

        $this->insert($fileChecksum);
    }

    function it_fail_on_insert_if_checksum_exists($collection, FileChecksum $fileChecksum)
    {
        $fileChecksum->getChecksum()->willReturn('check');
        $collection->has('check')->willReturn(true);
        $this->shouldThrow(\RuntimeException::CLASS)->duringInsert($fileChecksum);
    }
}
