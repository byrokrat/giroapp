<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\SettingsMapper;
use hanneskod\yaysondb\CollectionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SettingsMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection)
    {
        $this->beConstructedWith($collection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SettingsMapper::CLASS);
    }

    function it_can_read_value($collection)
    {
        $collection->findOne(Argument::any())->willReturn(['value' => 'bar']);
        $this->read('foo')->shouldBeLike('bar');
    }

    function it_defaults_to_empty_setting($collection)
    {
        $collection->findOne(Argument::any())->willReturn([]);
        $this->read('foo')->shouldBeLike('');
    }

    function it_can_update($collection)
    {
        $collection->update(Argument::cetera())->willReturn(1);
        $collection->commit()->shouldBeCalled();
        $this->write('foo', 'bar');
    }

    function it_can_insert($collection)
    {
        $collection->update(Argument::cetera())->willReturn(0);
        $collection->insert(['key' => 'foo', 'value' => 'bar'])->shouldBeCalled();
        $collection->commit()->shouldBeCalled();
        $this->write('foo', 'bar');
    }
}
