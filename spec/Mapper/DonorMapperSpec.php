<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Mapper\Arrayizer\DonorArrayizer;
use byrokrat\giroapp\Model\Donor;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\FilterableInterface;
use hanneskod\yaysondb\Operators as y;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection, DonorArrayizer $donorArrayizer)
    {
        $this->beConstructedWith($collection, $donorArrayizer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorMapper::CLASS);
    }

    function it_finds_donors_by_key($collection, $donorArrayizer, Donor $donor)
    {
        $collection->has('foobar')->willReturn(true);
        $collection->read('foobar')->willReturn(['foobar']);

        $donorArrayizer->fromArray(['foobar'])->willReturn($donor);
        
        $this->findByKey('foobar')->shouldEqual($donor);
    }

    function it_throws_exception_on_unknown_key($collection)
    {
        $collection->has('foobar')->willReturn(false);

        $this->shouldThrow(\RuntimeException::CLASS)->during('findByKey',['foobar']);
    }

    function it_can_save_donor($collection, $donorArrayizer, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('foobar');

        $donorArrayizer->toArray($donor)->willReturn(['asdf']);

        $collection->insert(['asdf'], 'foobar')->shouldBeCalled();

        $this->save($donor);
    }

    function it_can_find_all($collection, $donorArrayizer, Donor $donor1, Donor $donor2)
    {
        $collection->getIterator()->willReturn(new \ArrayIterator([['foo'], ['bar']]));

        $donorArrayizer->fromArray(['foo'])->willReturn($donor1);
        $donorArrayizer->fromArray(['bar'])->willReturn($donor2);

        $this->findAll()->shouldReturn([$donor1, $donor2]);
    }

    function it_can_find_active_donor($collection, $donorArrayizer, Donor $donor)
    {
        $collection->first(
            Argument::type(
                \hanneskod\yaysondb\Expression\ExpressionInterface::CLASS
            )
        )->willReturn(['foobar']);

        $donorArrayizer->fromArray(['foobar'])->willReturn($donor);

        $this->findByActivePayerNumber('foobar')->shouldEqual($donor);
    }

    function it_can_find_by_payernumber($collection, $donorArrayizer, Donor $donor1, Donor $donor2, FilterableInterface $filterableInterface)
    {
        $collection->find(
            Argument::type(
                \hanneskod\yaysondb\Expression\ExpressionInterface::CLASS
            )
        )->willReturn($filterableInterface);

        $filterableInterface->getIterator()->willReturn(
            new \ArrayIterator([['foo'], ['bar']])
        );

        $donorArrayizer->fromArray(['foo'])->willReturn($donor1);
        $donorArrayizer->fromArray(['bar'])->willReturn($donor2);

        $this->findByPayerNumber('foobar')->shouldReturn([$donor1, $donor2]);
    }

    function it_can_delete_donor($collection, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('foobar');

        $collection->delete(
            Argument::type(
                \hanneskod\yaysondb\Expression\ExpressionInterface::CLASS
            )
        )->shouldBeCalled();

        $this->delete($donor);
    }
}
