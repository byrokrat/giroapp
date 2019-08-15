<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Db;

use byrokrat\giroapp\Db\DonorEventStoreInterface;
use byrokrat\giroapp\Db\DonorEventEntry;

trait DonorEventStoreSpecTrait
{
    use DriverTestEnvironmentTrait;

    function it_is_an_event_store()
    {
        $this->shouldHaveType(DonorEventStoreInterface::class);
    }

    function it_returns_empty_iterator_if_no_entries()
    {
        $this->readEntriesForMandateKey('foobar')->shouldIterateAs([]);
    }

    function it_returns_file_entries()
    {
        $entry = new DonorEventEntry('key', 'type', new \DateTimeImmutable, ['data']);
        $this->addDonorEventEntry($entry);
        $this->addDonorEventEntry($entry);
        $this->readEntriesForMandateKey('key')->shouldYieldEntries($entry, $entry);
    }

    function it_ignores_other_entries()
    {
        $entry = new DonorEventEntry('foo', '', new \DateTimeImmutable, ['']);
        $this->addDonorEventEntry($entry);
        $this->addDonorEventEntry(new DonorEventEntry('bar', '', new \DateTimeImmutable, ['']));
        $this->readEntriesForMandateKey('foo')->shouldYieldEntries($entry);
    }

    function it_can_read_all_entries()
    {
        $foo = new DonorEventEntry('foo', '', new \DateTimeImmutable, ['']);
        $bar = new DonorEventEntry('bar', '', new \DateTimeImmutable, ['']);
        $this->addDonorEventEntry($foo);
        $this->addDonorEventEntry($bar);
        $this->readAllEntries()->shouldYieldEntries($foo, $bar);
    }

    public function getMatchers(): array
    {
        return [
            'yieldEntries' => function (iterable $result, DonorEventEntry ...$expectedEntries) {
                $result = iterator_to_array($result);
                foreach ($expectedEntries as $index => $expected) {
                    if (!isset($result[$index])) {
                        throw new \Exception("Expected entry index $index does not exist");
                    }

                    $entry = $result[$index];

                    if ($entry->getMandateKey() != $expected->getMandateKey()) {
                        throw new \Exception(sprintf(
                            "Unexpepcted mandate key '%s' in entry %s, expected '%s'",
                            $entry->getMandateKey(),
                            $index,
                            $expected->getMandateKey()
                        ));
                    }

                    if ($entry->getType() != $expected->getType()) {
                        throw new \Exception(sprintf(
                            "Unexpepcted event type '%s' in entry %s, expected '%s'",
                            $entry->getType(),
                            $index,
                            $expected->getType()
                        ));
                    }

                    if ($entry->getDateTime()->getTimestamp() != $expected->getDateTime()->getTimestamp()) {
                        throw new \Exception(sprintf(
                            "Unexpepcted datetime '%s' in entry %s, expected '%s'",
                            $entry->getDateTime()->format(\DateTime::W3C),
                            $index,
                            $expected->getDateTime()->format(\DateTime::W3C)
                        ));
                    }

                    if ($entry->getData() != $expected->getData()) {
                        throw new \Exception(sprintf(
                            "Unexpepcted data in entry %s",
                            $index
                        ));
                    }
                }

                return true;
            },
        ];
    }
}
