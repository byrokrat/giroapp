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
        $collection->has('foo')->willReturn(true);
        $collection->read('foo')->willReturn(['value' => 'bar']);
        $this->findByKey('foo')->shouldEqual('bar');
    }

    function it_defaults_to_empty_setting_on_read($collection)
    {
        $collection->has('foo')->willReturn(false);
        $this->findByKey('foo')->shouldBeLike('');
    }

    function it_can_save($collection)
    {
        $collection->insert(['value' => 'bar'], 'foo')->willReturn('')->shouldBeCalled();
        $this->save('foo', 'bar');
    }
}
