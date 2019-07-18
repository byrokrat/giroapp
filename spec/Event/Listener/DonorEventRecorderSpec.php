<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Event\Listener;

use byrokrat\giroapp\Event\Listener\DonorEventRecorder;
use byrokrat\giroapp\Event\Listener\DonorEventNormalizer;
use byrokrat\giroapp\Db\DonorEventEntry;
use byrokrat\giroapp\Db\DonorEventStoreInterface;
use byrokrat\giroapp\Domain\Donor;
use byrokrat\giroapp\Event\DonorEvent;
use byrokrat\giroapp\Utils\ClassIdExtractor;
use byrokrat\giroapp\Utils\SystemClock;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DonorEventRecorderSpec extends ObjectBehavior
{
    function let(
        DonorEventStoreInterface $eventStore,
        DonorEventNormalizer $normalizer,
        SystemClock $clock
    ) {
        $this->beConstructedWith($eventStore, $normalizer, $clock);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DonorEventRecorder::CLASS);
    }

    function it_adds_to_history(
        $eventStore,
        $normalizer,
        $clock,
        Donor $donor,
        DonorEvent $event
    ) {
        $event->getDonor()->willReturn($donor);
        $donor->getMandateKey()->willReturn('key');

        $datetime = new \DateTimeImmutable;
        $clock->getNow()->willReturn($datetime);

        $normalizer->normalizeEvent($event)->willReturn(['data']);

        $eventStore->addDonorEventEntry(
            new DonorEventEntry(
                'key',
                (string)new ClassIdExtractor($event->getWrappedObject()),
                $datetime,
                ['data']
            )
        )->shouldBeCalled();

        $this->__invoke($event);
    }
}
