<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Model\Donor;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\FilterableInterface;
use hanneskod\yaysondb\Expression\ExpressionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection, DonorSchema $donorSchema)
    {
        $this->beConstructedWith($collection, $donorSchema);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorMapper::CLASS);
    }

    function it_finds_donors_by_key($collection, $donorSchema, Donor $donor)
    {
        $collection->has('foobar')->willReturn(true);
        $collection->read('foobar')->willReturn(['foobar']);
        $donorSchema->fromArray(['foobar'])->willReturn($donor);

        $this->findByKey('foobar')->shouldEqual($donor);
    }

    function it_throws_exception_on_unknown_key($collection)
    {
        $collection->has('foobar')->willReturn(false);

        $this->shouldThrow(\RuntimeException::CLASS)->during('findByKey', ['foobar']);
    }

    function it_can_save_donor($collection, $donorSchema, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('foobar');
        $donorSchema->toArray($donor)->willReturn(['asdf']);
        $collection->insert(['asdf'], 'foobar')->shouldBeCalled();

        $this->save($donor);
    }

    function it_can_find_all($collection, $donorSchema, Donor $donor1, Donor $donor2)
    {
        $collection->getIterator()->willReturn(new \ArrayIterator([['foo'], ['bar']]));
        $donorSchema->fromArray(['foo'])->willReturn($donor1);
        $donorSchema->fromArray(['bar'])->willReturn($donor2);

        $this->findAll()->shouldReturn([$donor1, $donor2]);
    }

    function it_can_find_active_donor($collection, $donorSchema, Donor $donor, ExpressionInterface $expr)
    {
        $donorSchema->getPayerNumberSearchExpression('payer-number')->willReturn($expr);
        $collection->findOne($expr)->willReturn(['SCHEMA_DOCUMENT']);
        $donorSchema->fromArray(['SCHEMA_DOCUMENT'])->willReturn($donor);

        $this->findByActivePayerNumber('payer-number')->shouldEqual($donor);
    }

    function it_can_find_by_payer_number(
        $collection,
        $donorSchema,
        Donor $donor1,
        Donor $donor2,
        FilterableInterface $documents,
        ExpressionInterface $expr
    ) {
        $donorSchema->getPayerNumberSearchExpression('payer-number')->willReturn($expr);
        $collection->find($expr)->willReturn($documents);
        $documents->getIterator()->willReturn(new \ArrayIterator([['foo'], ['bar']]));
        $donorSchema->fromArray(['foo'])->willReturn($donor1);
        $donorSchema->fromArray(['bar'])->willReturn($donor2);

        $this->findByPayerNumber('payer-number')->shouldReturn([$donor1, $donor2]);
    }

    function it_can_delete_donor($collection, $donorSchema, Donor $donor, ExpressionInterface $expr)
    {
        $donor->getMandateKey()->willReturn('mandate-key');
        $donorSchema->getMandateKeySearchExpression('mandate-key')->willReturn($expr);
        $collection->delete($expr)->shouldBeCalled();

        $this->delete($donor);
    }

    function it_can_report_existing_donor($collection)
    {
        $collection->has('foobar')->willReturn(true);

        $this->hasKey('foobar')->shouldReturn(true);
    }

    function it_can_report_nonexisting_donor($collection)
    {
        $collection->has('foobar')->willReturn(false);

        $this->hasKey('foobar')->shouldReturn(false);
    }
}
