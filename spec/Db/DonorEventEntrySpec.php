<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DonorEventEntry;
use PhpSpec\ObjectBehavior;

class DonorEventEntrySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith('', '', new \DateTimeImmutable(), []);
        $this->shouldHaveType(DonorEventEntry::class);
    }

    function it_contains_a_mandate_key()
    {
        $this->beConstructedWith('mandate-key', '', new \DateTimeImmutable(), []);
        $this->getMandateKey()->shouldEqual('mandate-key');
    }

    function it_contains_a_type()
    {
        $this->beConstructedWith('', 'type', new \DateTimeImmutable(), []);
        $this->getType()->shouldEqual('type');
    }

    function it_contains_a_date_time()
    {
        $datetime = new \DateTimeImmutable();
        $this->beConstructedWith('', '', $datetime, []);
        $this->getDateTime()->shouldEqual($datetime);
    }

    function it_contains_data()
    {
        $this->beConstructedWith('', '', new \DateTimeImmutable(), ['data']);
        $this->getData()->shouldEqual(['data']);
    }
}
