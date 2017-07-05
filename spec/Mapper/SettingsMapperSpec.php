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

    function it_can_commit($collection)
    {
        $collection->inTransaction()->willReturn(true);
        $collection->commit()->shouldBeCalled();
        $this->commit();
    }

    function it_ignores_commit_if_not_in_transaction($collection)
    {
        $collection->inTransaction()->willReturn(false);
        $collection->commit()->shouldNotBeCalled();
        $this->commit();
    }

    function it_can_read_value($collection)
    {
        $collection->has('foo')->willReturn(true);
        $collection->read('foo')->willReturn(['value' => 'bar']);
        $this->read('foo')->shouldEqual('bar');
    }

    function it_defaults_to_empty_setting_on_read($collection)
    {
        $collection->has('foo')->willReturn(false);
        $this->read('foo')->shouldBeLike('');
    }

    function it_can_write($collection)
    {
        $collection->insert(['value' => 'bar'], 'foo')->willReturn('')->shouldBeCalled();
        $this->write('foo', 'bar');
    }
}
