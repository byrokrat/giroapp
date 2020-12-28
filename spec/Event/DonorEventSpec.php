<?php

declare(strict_types=1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Domain\Donor;
use PhpSpec\ObjectBehavior;

class DonorEventSpec extends ObjectBehavior
{
    function let(Donor $donor)
    {
        $donor->getMandateKey()->willReturn('');
        $this->beConstructedThrough(function () use ($donor) {
            return new class ('message', $donor->getWrappedObject()) extends DonorEvent {
            };
        });
    }

    function it_contains_a_donor($donor)
    {
        $this->getDonor()->shouldEqual($donor);
    }

    function it_contains_a_message($donor)
    {
        $this->getMessage()->shouldBeLike('message');
    }
}
