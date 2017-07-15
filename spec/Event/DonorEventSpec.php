<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event;

use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Model\Donor;
use Symfony\Component\EventDispatcher\Event;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorEventSpec extends ObjectBehavior
{
    function let(Donor $donor)
    {
        $this->beConstructedWith('', $donor);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorEvent::CLASS);
    }

    function it_is_an_event()
    {
        $this->shouldHaveType(Event::CLASS);
    }

    function it_contains_a_donor($donor)
    {
        $this->getDonor()->shouldEqual($donor);
    }

    function it_contains_a_message($donor)
    {
        $this->beConstructedWith('message', $donor);
        $this->getMessage()->shouldBeLike('message');
    }
}
