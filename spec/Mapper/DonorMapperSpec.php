<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use byrokrat\giroapp\Mapper\DonorMapper;
use byrokrat\giroapp\Mapper\Schema\DonorSchema;
use byrokrat\giroapp\Model\Donor;
use byrokrat\giroapp\Utils\SystemClock;
use byrokrat\banking\AccountNumber;
use byrokrat\id\IdInterface;
use hanneskod\yaysondb\CollectionInterface;
use hanneskod\yaysondb\FilterableInterface;
use hanneskod\yaysondb\Expression\ExpressionInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorMapperSpec extends ObjectBehavior
{
    function let(CollectionInterface $collection, DonorSchema $donorSchema, SystemClock $systemClock)
    {
        $this->beConstructedWith($collection, $donorSchema, $systemClock);
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

    function it_can_create_donor($collection, $donorSchema, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('mandate_key');
        $donor->getPayerNumber()->willReturn('payer_number');

        $search = new ExpressionToken;

        $search->shouldMatch([
            'payer_number' => 'payer_number',
            'mandate_key' => '!mandate_key',
            'state' => '!INACTIVE'
        ]);

        $search->shouldNotMatch([
            'payer_number' => 'payer_number',
            'mandate_key' => 'mandate_key',
            'state' => '!INACTIVE'
        ]);

        $search->shouldNotMatch([
            'payer_number' => 'payer_number',
            'mandate_key' => '!mandate_key',
            'state' => 'INACTIVE'
        ]);

        $collection->findOne($search)->shouldBeCalled()->willReturn([]);

        $donorSchema->toArray($donor)->willReturn(['SCHEMA']);

        $collection->has('mandate_key')->willReturn(false);
        $collection->insert(['SCHEMA'], 'mandate_key')->shouldBeCalled();

        $this->create($donor);
    }

    function it_fails_on_create_if_active_mandate_exists($collection, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('mandate_key');
        $donor->getPayerNumber()->willReturn('');
        $collection->has('mandate_key')->willReturn(false);
        $collection->findOne(new ExpressionToken)->shouldBeCalled()->willReturn(['NOT EMPTY']);

        $this->shouldThrow(\RuntimeException::CLASS)->duringCreate($donor);
    }

    function it_fails_create_if_mandate_key_exists($collection, Donor $donor, IdInterface $id, AccountNumber $account)
    {
        $id->format('S-sk')->willReturn('');
        $account->getNumber()->willReturn('');
        $donor->getDonorId()->willReturn($id);
        $donor->getAccount()->willReturn($account);
        $donor->getMandateKey()->willReturn('mandate_key');
        $collection->has('mandate_key')->willReturn(true);

        $this->shouldThrow(\RuntimeException::CLASS)->duringCreate($donor);
    }

    function it_can_update_donor($collection, $donorSchema, $systemClock, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('mandate_key');
        $donor->getPayerNumber()->willReturn('payer_number');
        $collection->findOne(new ExpressionToken)->shouldBeCalled()->willReturn([]);
        $donorSchema->toArray($donor)->willReturn(['SCHEMA']);
        $collection->has('mandate_key')->willReturn(true);
        $collection->insert(['SCHEMA'], 'mandate_key')->shouldBeCalled();
        $date = new \DateTime;
        $systemClock->getNow()->willReturn($date);
        $donor->setUpdated($date)->shouldBeCalled();

        $this->update($donor);
    }

    function it_fails_on_update_if_mandate_key_does_not_exist($collection, Donor $donor)
    {
        $donor->getMandateKey()->willReturn('mandate_key');
        $collection->has('mandate_key')->willReturn(false);
        $this->shouldThrow(\RuntimeException::CLASS)->duringUpdate($donor);
    }

    function it_can_find_all($collection, $donorSchema, Donor $donor1, Donor $donor2)
    {
        $collection->getIterator()->willReturn(new \ArrayIterator([['foo'], ['bar']]));
        $donorSchema->fromArray(['foo'])->willReturn($donor1);
        $donorSchema->fromArray(['bar'])->willReturn($donor2);

        $this->findAll()->shouldIterateAs([$donor1, $donor2]);
    }

    function it_can_find_by_payer_number($collection, $donorSchema, Donor $donor, FilterableInterface $documents)
    {
        $search = (new ExpressionToken)
            ->shouldMatch(['payer_number' => 'payer-number'])
            ->shouldNotMatch(['payer_number' => 'another-payer-number']);

        $collection->find($search)->willReturn($documents);
        $documents->getIterator()->willReturn(new \ArrayIterator([['foo'], ['bar']]));
        $donorSchema->fromArray(['foo'])->willReturn($donor);
        $donorSchema->fromArray(['bar'])->willReturn($donor);

        $this->findByPayerNumber('payer-number')->shouldIterateAs([$donor, $donor]);
    }

    function it_can_find_by_active_payer_number($collection, $donorSchema, Donor $donor)
    {
        $search = new ExpressionToken;

        $search->shouldMatch([
            'payer_number' => 'payer-number',
            'state' => 'ACTIVE'
        ]);

        $search->shouldNotMatch([
            'payer_number' => 'another-payer-number',
            'state' => 'ACTIVE'
        ]);

        $search->shouldNotMatch([
            'payer_number' => 'payer-number',
            'state' => 'INACTIVE'
        ]);

        $collection->findOne($search)->willReturn(['DOCUMENT']);
        $donorSchema->fromArray(['DOCUMENT'])->willReturn($donor);

        $this->findByActivePayerNumber('payer-number')->shouldEqual($donor);
    }

    function it_fails_if_active_payer_number_does_not_exist($collection, Donor $donor)
    {
        $collection->findOne(new ExpressionToken)->willReturn([]);
        $this->shouldThrow(\RuntimeException::CLASS)->during('findByActivePayerNumber', ['']);
    }

    function it_can_delete_donor($collection, Donor $donor)
    {
        $search = (new ExpressionToken)
            ->shouldMatch(['mandate_key' => 'mandate-key'])
            ->shouldNotMatch(['mandate_key' => 'another-mandate-key']);

        $donor->getMandateKey()->willReturn('mandate-key');
        $collection->delete($search)->shouldBeCalled();

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
